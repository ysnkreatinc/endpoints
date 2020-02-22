<?php

namespace Kreatinc\Bot\Libraries\Facebook;

use Facebook\Facebook;
use Kreatinc\Bot\Libraries\L2L\Client as L2LClient;
use Kreatinc\Bot\Libraries\L2L\MessengerProfile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Exception;

class Client
{
    protected $facebook;

    protected $token;

    protected $recipient;

    public function __construct()
    {
        $this->facebook = new Facebook([
                'app_id' => config('bot.facebook.app.id'),
                'app_secret' => config('bot.facebook.app.secret'),
                'default_graph_version' => config('bot.facebook.app.graph_version')
            ]);
    }

    public function setToken($token)
    {
        return $this->token = $token;
    }

    public function setRecipient($recipient)
    {
        return $this->recipient = $recipient;
    }

    /**
     * Send a message to the user.
     *
     * @param array $message
     * @return object
     */
    public function sendMessage($message)
    {
        return $this->postMessage([
            'message' => $message
        ]);
    }

    /**
     * Display 'is typing' action for the recipient to see
     * @param bool $setOn
     */
    public function sendIsTypingAction($setOn = true)
    {
        $this->postMessage([
            'sender_action' => ($setOn ? 'typing_on' : 'typing_off')
        ]);
    }

    /**
     * Mark last message as read
     */
    public function sendSeenAction()
    {
        $this->postMessage([
            'sender_action' => 'mark_seen'
        ]);
    }

    protected function postMessage($content)
    {
        if (empty($this->recipient)) {
            throw new \Exception('The Recipient is missing!');
        }

        $content['recipient'] = [
            'id' => $this->recipient
        ];

        $this->post('me/messages', $content);
    }

    public function getFacebookUser($user_id)
    {
        return $this->get("/{$user_id}");
    }

    public function getPages()
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your Facebook User token to make any API requests.');
        }

        return $this->facebook->get('/me/accounts?type=page', $this->token)->getDecodedBody();
    }

    public function generateLoginUrl()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        $permissions = [
            'public_profile',
            'email',
            'manage_pages',
            // 'publish_pages',
            'pages_show_list',
            'pages_messaging',
        ];

        // Always generate securl URL's in all environments.
        // Facebook always require secure URL's so it's safe to use it.
        $secureURL = secure_url(URL::route('facebook.login.callback', [], false));

        return $helper->getLoginUrl($secureURL, $permissions); // config('bot.facebook.app.redirect')
    }

    public function generateLogoutUrl()
    {
        $helper = $this->facebook->getRedirectLoginHelper();

        return $helper->getLogoutUrl($this->token, secure_url(env('FACEBOOK_APP_LOGOUT_REDIRECT_URI')));
    }

    public function addPage($pageID)
    {
        $content = [
            'subscribed_fields' => 'general_info, personal_info, messages, messaging_postbacks, message_deliveries, message_reads, message_echoes, messaging_referrals, messaging_optins',
            // , messaging_payments, messaging_pre_checkouts, messaging_checkout_updates, messaging_account_linking, messaging_referrals, messaging_game_plays, standby, messaging_handovers, messaging_policy_enforcement,
        ];

        return $this->post("/$pageID/subscribed_apps", $content);
    }

    public function removePage($pageID)
    {
        return $this->facebook->delete("/$pageID/subscribed_apps", [], $this->token);
    }

    /**
     * Page subscribed apps.
     *
     * @param  string  $pageID
     * @return array
     */
    public function pageSubscribedApps($pageID)
    {
        return $this->facebook->get("/$pageID/subscribed_apps", $this->token)->getDecodedBody();
    }

    /**
     * Send POST Requests to Facebook API
     */
    public function post($endpoint, $content)
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your Facebook Page token to make any API requests.');
        }

        try {
            return $this->facebook->post($endpoint, $content, $this->token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            throw $e;
        } catch (Facebook\Excepptions\FacebookSDKException $e) {
            throw $e;
        }
    }

    /**
     * Sends a DELETE request to Graph and returns the result.
     *
     * @param  string $endpoint
     * @param  array  $params
     *
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function delete(string $endpoint, array $params)
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your Facebook Page token to make any API requests.');
        }

        return $this->facebook->delete($endpoint, $params, $this->token);
    }

    /**
     * Send GET Requests to Facebook API
     */
    public function get($endpoint)
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your Facebook Page token to make any API requests.');
        }

        try {
            $res = $this->facebook->get($endpoint, $this->token);
            return $res->getGraphNode()->all();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            throw $e;
        } catch (Facebook\Excepptions\FacebookSDKException $e) {
            throw $e;
        }
    }

    /**
     * Update Page Profile Data.
     *
     * @param  MessengerProfile $profile
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function updateMessengerProfile(MessengerProfile $profile)
    {
        return $this->post('/me/messenger_profile', $profile->toArray());
    }

    /**
     * Add Get Started Button to a Page.
     *
     * @see https://developers.facebook.com/docs/messenger-platform/reference/messenger-profile-api/get-started-button/
     *
     * @param  array  $content
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function addGetStarted(array $content)
    {
        return $this->post('/me/messenger_profile', [
            'get_started' => $content,
        ]);
    }

    /**
     * Add Persistent Menu to a Page.
     *
     * @see https://developers.facebook.com/docs/messenger-platform/reference/messenger-profile-api/persistent-menu
     *
     * @param  array  $content
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function addPersistentMenuToMessanger(array $content)
    {
        return $this->post('/me/messenger_profile', [
            // Get Started Button is necessary for the persistent Menu
            'get_started' => [
                'payload' => 'get_started.clicked',
            ],
            'persistent_menu' => [
                $content,
            ],
        ]);
    }

    /**
     * Remove Profile Properties from a Page.
     *
     * @see https://developers.facebook.com/docs/messenger-platform/reference/messenger-profile-api/#delete
     *
     * @param  array  $content
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function removeProfileProperties(array $content)
    {
        return $this->delete('/me/messenger_profile', [
            'fields' => $content,
        ], $this->token);
    }

    /**
     * Add Greeting message on the welcome screen.
     *
     * @see https://developers.facebook.com/docs/messenger-platform/reference/messenger-profile-api/greeting/
     *
     * @param  array        $content
     * @param  null|int     $listing_id
     * @param  null|string  $l2l_token
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function addGreetingText(array $content, $listing_id = null, $l2l_token = null)
    {
        if (is_numeric($listing_id) && Str::contains($content['text'], '{{listing_address}}')) {
            // "Listings To Leads" Http Client.
            $client = new L2LClient();
            $client->token($l2l_token);

            // Get the listing information.
            $listing = $client->listingInformation($listing_id);

            // Replace Listing template variable with Listing address.
            $content['text'] = str_replace(
                '{{listing_address}}',
                $listing['address'],
                $content['text']
            );
        }

        return $this->post('/me/messenger_profile', [
            'greeting' => [$content],
        ]);
    }

    /**
     * Whitelisting domains for a page.
     *
     * @param  array  $domains
     * @return \Facebook\FacebookResponse
     * @throws \Exception
     */
    public function whitelistDomains(array $domains)
    {
        return $this->post('/me/messenger_profile', [
            'whitelisted_domains' => $domains,
        ]);
    }

    /**
     * Get the user profile picture information.
     *
     * @param  string  $user_id
     * @return array
     */
    public function userProfilePic($user_id)
    {
        return $this->facebook->get("/$user_id/picture?redirect=0");
    }

    /**
     * Handle dynamic method calls
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->facebook, $method)) {
            return $this->facebook->$method(...$parameters);
        }

        throw new \Exception("Undefined Method: $method");
    }
}
