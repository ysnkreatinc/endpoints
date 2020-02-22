<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Services\FacebookService;

class FacebookController extends Controller
{
    public function __construct(FacebookService $service)
    {
        $this->service = $service;
    }

    /**
     * When you put this url in the messenger app webhooks, facebook will send a request to verify the Tokan we gave them
     *
     * This endpoint is responsible for that.
     */
    public function verifyToken(Request $request)
    {
        try {
            $request->validate([
                'hub_mode'          => 'required|in:subscribe',
                'hub_verify_token'  => 'required|string',
                'hub_challenge'     => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            abort(403);
        }

        if ($this->service->verifyMessengerToken($request->input('hub_verify_token'))) {
            return $request->input('hub_challenge');
        }

        return abort(403);
    }

    /**
     * This endpoint receives the Facebook Messenger Webhooks, of all messaging events
     * Ex: We will receive any messages sent by users to the page,
     * as well as other events like 'read', 'seen' etc.
     */
    public function receiveWebhook(Request $request)
    {
        try {
            $request->validate([
                'entry.*.messaging' => 'required',
                'object'            => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            abort(404);
        }

        // If the request is a message to a Facebook page,
        // we will process the message and send a reply
        if ($request->input('object') === 'page') {
            $this->service->processMessengerEntry($request->input('entry'));

            return response('OK');
        }

        return abort(404);
    }

    public function messenger($agent)
    {
        $pageID = Page::where('agent_id', $agent)->firstOrFail()->account_id;

        $html = "<!-- Load Facebook SDK for JavaScript -->
        <div id=\"fb-root\"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              xfbml            : true,
              version          : 'v3.2'
            });
          };

          (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <!-- Your customer chat code -->
        <div class=\"fb-customerchat\"
          attribution=setup_tool
          page_id=\"{$pageID}\"
          ref=\"chat-widget\"
          logged_in_greeting=\"Hello there! I'm happy to answer your questions about buying or selling a home.\"
          logged_out_greeting=\"Hello there! I'm happy to answer your questions about buying or selling a home.\">
        </div>";

        return response($html);
    }

    /**
     * Display facebook button that make the user login in with facebook account.
     * This just generate the login URL.
     *
     * Please Include 'member_id' as query parameter
     * It's the l2l member ID we store after successful Facebook login
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $loginUrl = $this->service->generateFacebookLogin();
        $memberID = $request->query('member_id');

        $url = sprintf('%s&state=%s', $loginUrl, $memberID);
        return response('<a href="'. $url .'">Log in with Facebook!</a>');
    }

    /**
     * Handle facebook login, From here we get the user access token.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback(Request $request)
    {
        if ($request->has('error')) {
            return redirect(config('bot.facebook.app.redirect').'?errors='. $request->input('error_description', 'FAILED LOGIN'));
        }

        // Validate the request.
        $validator = Validator::make($request->all(), [
                'code'  => 'required|string',
                'state' => 'required|string',
        ]);
        if ($validator->fails()) {
            abort(404);
        }

        [$memberID, $accessToken, $agentID, $fbID] = $this->service->handleFacebookUser($request->all());

        $to = config('bot.facebook.app.redirect') ."?agent_id=$agentID&facebook_user_id=$fbID&access_token=$accessToken&l2l_member_id=$memberID";

        return redirect($to);
    }

    /**
     * List all the user facebook pages from Facebook.
     * From here the user can go the subscribe handler.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $request->validate([
            'l2l_member_id'    => 'required|string',
            'facebook_user_id' => 'string',
        ]);

        try {
            list($pages, $agentID, $fbID) = $this->service->listFacebookPages($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json([
                'agent_id' => $agentID,
                'facebook_user_id' => $fbID,
                'pages' => $pages
            ]);
    }

    /**
     * Subscribe the user to our application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribePage(Request $request)
    {
        $request->validate([
            'id'               => 'required|string',
            'name'             => 'required|string',
            'facebook_user_id' => 'required|string',
            'access_token'     => 'required|string',
            'l2l_token'        => 'required|string',
            'listing_id'       => 'integer',
            'l2l_member_id'    => 'integer',
        ]);

        $this->service->addFacebookPage($request->all());

        return response()->json(['message' => 'Thank you, You successfully subscribed to the BOT']);
    }

    /**
     * Unsubscribe the user from our application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribePage(Request $request)
    {
        $request->validate([
            'page_id'    => 'required|string',
        ]);

        $this->service->removeFacebookPage($request->all());

        return response()->json(['message' => 'Thank you, You successfully unsubscribed from the BOT.']);
    }

    /**
     * Reply from GUI to subscriber
     * @param  \Illuminate\Http\Request
     * @return
     */

    public function messageSubscribers($page, $user, Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        try {
            $this->service->sendMessageToSubscriber($page, $user, $request->input('message'));
          } catch (Facebook\Exceptions\FacebookResponseException $e) {
            \Log::error('FacebookException');
            return response()->json('error', $e->getMessage());
          }

        return response()->json(['message' => 'Message sent successfully.']);
    }
}
