<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Routing\Controller;
use Kreatinc\Bot\Libraries\Facebook\Client;

// Models
use Kreatinc\Bot\Models\Bot;
use Kreatinc\Bot\Models\LeadClient;
use Kreatinc\Bot\Models\Filters\SubscribersFilters;

class SubscriberController extends Controller
{
    /**
     * List of the bot subscribers.
     *
     * @param  int  $bot
     * @param  \Kreatinc\Bot\Models\Filters\SubscribersFilters  $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($bot, SubscribersFilters $filters)
    {
        $bot = Bot::findOrFail($bot);

        // Sort
        $sort = 'DESC';
        if (request()->has('sort')) {
            $sort = request()->sort;
        }

        $subscribers = $bot->subscribers()->where(function ($builder) use ($filters) {
            return $builder->filter($filters);
        })->orderBy(request()->order_by ?? 'created_at', $sort)
          ->paginate((int) request()->per_page ?? 15)
          ->appends(request()->all());

        return response()->json($subscribers);
    }

    /**
     * Display the subscriber information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(
            LeadClient::findOrFail($id)
        );
    }

    /**
     * Enable the bot for this subscriber.
     *
     * @param  int  $subscriberID
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable($subscriberID)
    {
        $subscriber = LeadClient::findOrFail($subscriberID);
        $subscriber->turnOnTheBot();

        return response()->json(true);
    }

    /**
     * Disable the bot for this subscriber.
     *
     * @param  int  $subscriberID
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable($subscriberID)
    {
        $subscriber = LeadClient::findOrFail($subscriberID);
        $subscriber->stopTheBotPermanently();

        return response()->json(true);
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $subscriber = LeadClient::findOrFail($id);

        $subscriber->update(request()->validate([
            'first_name' => 'string',
            'last_name'  => 'string',
            'email'      => 'string',
            'phone'      => 'string',
            'address'    => 'string',
            'type'       => 'string',
        ]));

        return response()->json($subscriber);
    }

    /**
     * Delete a subscriber.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $subscriber = LeadClient::findOrFail($id);
        $subscriber->delete();

        return response()->json([], 204);
    }

    /**
     * Subscriber conversations.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function conversations($id)
    {
        $subscriber = LeadClient::findOrFail($id);

        // Only the conversations for the current bot page.
        $response = $subscriber->conversations()
                               ->with('messages')
                               ->where('page_id', $subscriber->bot->page->id)
                               ->paginate();

        return response()->json($response);
    }

    /**
     * Subscriber profile information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile($id)
    {
        $subscriber = LeadClient::findOrFail($id);
        if (empty($subscriber->profile_pic)) {
            try {
                $client = new Client();
                $client->setToken($subscriber->bot->page->access_token);
                $data = $client->getFacebookUser($subscriber->account_id);
                $subscriber->profile_pic = data_get($data, 'profile_pic');
                $subscriber->save();
            } catch (\Exception $e) {
                if (is_facebook_token_error($e)) {
                    $subscriber->bot->page->access_token = null;
                    $subscriber->bot->page->save();
                    $subscriber->bot->status = false;
                    $subscriber->bot->save();
                }
            }
        }

        return response()->json(
            $subscriber->transform(),
            200, [], JSON_UNESCAPED_SLASHES
        );
    }
}
