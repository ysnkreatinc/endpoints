<?php

namespace Kreatinc\Bot\Services;

use Illuminate\Support\Arr;
use Kreatinc\Bot\Exceptions\SilentException;
use Kreatinc\Bot\Chat\ChatManager;
use Kreatinc\Bot\Libraries\Facebook\FacebookMessaging;
use Kreatinc\Bot\Libraries\Facebook\IncomingMessage;
use Kreatinc\Bot\Libraries\Facebook\Client;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Models\Agent;

class FacebookService
{
    protected $chatManager;

    public function __construct(FacebookMessaging $messenger)
    {
        $this->chatManager = new ChatManager($messenger);
        $this->client = new Client();
    }

    /**
     * Process the message and send a custom reply
     */
    public function processMessengerEntry($entries)
    {
        foreach ($entries as $entry) {
            foreach (Arr::get($entry, 'messaging', []) as $content) {
                // Get the important message parts from the payload
                $message = new IncomingMessage($entry['id'], $content);

                try {
                    // The ChatManager does all the work needed then reply to the messages
                    return $this->chatManager->handleIncomingMessage($message);
                }
                catch (SilentException $e) {
                    \Log::info('SILENT EXCEPTION:');
                    // \Log::error($e);
                    \Log::error($e->getMessage());
                }
                catch (\Exception $e) {
                    $page = $this->chatManager->getChatPage();
                    $bot = $this->chatManager->getChatBot();
                    if (is_facebook_token_error($e)) {
                        $page->access_token = null;
                        $page->save();
                        $bot->status = false;
                        $bot->save();
                    }
                    \Log::info('BOT ERROR:', ['id' => $bot->id ?? '', $bot->title ?? '']);
                    \Log::info('PAGE ERROR:', [$page->name ?? '', $page->account_id ?? '']);
                    \Log::error($e);
                }
            }
        }

        return $this->chatManager->replyWithUnsupportedMessage();
    }

    public function sendMessageToSubscriber($pageID, $subscriber, $message)
    {
        return $this->chatManager->messageToSubscriber($pageID, $subscriber, $message);
    }

    public function verifyMessengerToken($messengerToken)
    {
        $verifyToken = config('bot.facebook.messenger.verify_token');

        return $messengerToken === $verifyToken;
    }

    public function generateFacebookLogin()
    {
        return $this->client->generateLoginUrl();
    }

    public function generateFacebookLogout($fb_user_id)
    {
        $agent = Agent::where('account_id', $fb_user_id)->first();
        if (! $agent) {
            throw new \Exception('That facebook user isn\'t subscribed to this app!');
        }
        $this->client->setToken($agent->access_token);

        return $this->client->generateLogoutUrl();
    }

    public function handleFacebookUser($data)
    {
        $helper = $this->client->getRedirectLoginHelper();
        if (Arr::has($data, 'state') && $data['state']) {
            $helper->getPersistentDataHandler()->set('state', $data['state']);
        }

        // Get access token.
        $accessToken = $helper->getAccessToken()->getValue();

        // Set the user token into the client.
        $this->client->setToken($accessToken);

        // Grap the user info.
        $userData = $this->client->getFacebookUser('me?fields=id,first_name,last_name,email');

        // Update agent data or create new one.
        $agent = Agent::withTrashed()->updateOrCreate(
            ['l2l_member_id' => $data['state']],
            [
                'account_id'    => $userData['id'],
                'access_token'  => $accessToken,
                'l2l_member_id' => $data['state'],
                'first_name'    => $userData['first_name'],
                'last_name'     => $userData['last_name'],
                'email'         => $userData['email'] ?? '',
            ]
        );
        $agent->restore();

        return [
            $data['state'],
            $accessToken,
            $agent->id,
            $agent->account_id
        ];
    }

    public function listFacebookPages($data)
    {
        $agent = Agent::where('l2l_member_id', $data['l2l_member_id'])->first();
        if (! $agent) {
            $agent = Agent::where('account_id', Arr::get($data, 'facebook_user_id'))->sort('id', 'desc')->first();
        } elseif (! $agent) {
            throw new \Exception('That facebook user isn\'t subscribed to this app!');
        }

        $this->client->setToken($agent->access_token);
        try {
            $pages = $this->client->getPages();
        } catch (\Exception $e) {
            if (is_facebook_token_error($e)) {
                $agent->access_token = '';
                $agent->save();
            }
            throw $e;
        }

        return [$pages['data'], $agent->id, $agent->account_id];
    }

    /**
     * Create the page and subscribe it to our bot.
     *
     * @param  array $data
     * @return \Kreatinc\Bot\Models\Page
     */
    public function addFacebookPage($data)
    {
        $agent = Agent::where('account_id', $data['facebook_user_id'])->first();

        $this->client->setToken($data['page_token']);
        $this->client->addPage($data['page_id']);

        $page = Page::createOrRestore(
            $data['page_id'],
            $data['page_token'],
            $data['page_name'],
            $agent->id
        );
        $agent->setL2LToken($data['l2l_token']);

        // Set agent l2l_member_id value.
        if (Arr::has($data, 'l2l_member_id')) {
            $agent->setL2LMemberID($data['l2l_member_id']);
        }

        // Set Bot ID.
        if (Arr::has($data, 'bot_id')) {
            $page->setBotID($data['bot_id']);
        }

        // Add Greeting message to the welcome screen.
        $this->client->addGreetingText([
            'locale' => 'default',
            'text' => "Hey {{user_first_name}} 👋, thanks for joining us on Messenger! \nI'm happy to answer your questions about buying or selling a home. \nClick get started to start.",
        ]);

        // Add Persistent Menu.
        $this->addPersistentMenu($data['page_token']);

        return $page;
    }

    public function removeFacebookPage($data)
    {
        $page = Page::findByAccountID($data['page_id']);
        $this->client->setToken($page->access_token);

        // Remove "Get Started", "Persistent Menu", "Greeting".
        $this->client->removeProfileProperties(['get_started', 'persistent_menu', 'greeting']);

        // Remove Page
        $this->client->removePage($page->account_id);
    }

    /**
     * Subscribe a page to our application.
     *
     * @param  Page  $page
     * @return \Facebook\FacebookResponse
     */
    public function subscribePage($page)
    {
        $this->client->setToken($page->access_token);

        try {
            $this->client->addPage($page->account_id);
        } catch (\Exception $e) {
            if (is_facebook_token_error($e)) {
                $page->access_token = null;
                $page->save();
            }
        }
    }

    /**
     * Unsubscribe a page from our application.
     *
     * @param  Page  $page
     * @return \Facebook\FacebookResponse|bool
     */
    public function unsubscribePage($page)
    {
        if (! $page) {
            return;
        }
        $this->client->setToken($page->access_token);

        try {
            // Get the page subscribed application.
            $pageApps = $this->client->pageSubscribedApps($page->account_id);

            // Check if our application in the page apps.
            $appExists = array_search(
                config('bot.facebook.app.id'),
                array_column($pageApps['data'], 'id')
            );
            if ($appExists === false) {
                return false;
            }

            $this->client->removeProfileProperties(['get_started', 'persistent_menu', 'greeting']);
            $this->client->removePage($page->account_id);
        } catch (\Exception $e) {
            $page->access_token = null;
            $page->save();
        }
    }

    /**
     * Add The Persistent Menu to a Page.
     *
     * @param  Bot  $bot
     * @return void
     */
    public function addPersistentMenu($bot)
    {
        if (! $bot->settings->presistent_menu) {
            return ;
        }
        $this->client->setToken($bot->page->access_token);

        // Facebook doesn't allow more than 3 items in the menu
        // TODO try nested items
        // TODO use 'in_menu' pivot field
        if ($bot->intents->count() > 3) {
            $intents = $bot->intents->where('slug', '!=', 'buyer');
        } else {
            $intents = $bot->intents;
        }

        // Actions
        $actions = $intents->map(function ($intent) {
            return [
                'title'   => $intent->getLabel(),
                'type'    => 'postback',
                'payload' => 'menu.'. $intent->slug,
            ];
        })->toArray();

        if (empty($actions)) {
            return ;
        }

        try {
            $this->client->addPersistentMenuToMessanger([
                'locale'          => 'default',
                'call_to_actions' => $actions,
            ]);
        } catch (\Exception $e) {
            if (is_facebook_token_error($e)) {
                $bot->page->access_token = null;
                $bot->page->save();
            }
        }
    }

}
