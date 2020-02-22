<?php

namespace Kreatinc\Bot\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kreatinc\Bot\Models\Agent;
use Kreatinc\Bot\Models\Bot;
use Kreatinc\Bot\Models\BotHistory;
use Kreatinc\Bot\Models\Intent;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Requests\AddBotIntentRequest;
use Kreatinc\Bot\Requests\BotSettingsRequest;
use Kreatinc\Bot\Requests\CreateBotRequest;
use Kreatinc\Bot\Requests\UpdateBotRequest;
use Kreatinc\Bot\Services\FacebookService;

class BotController extends Controller
{
    /** @var \Kreatinc\Bot\Services\FacebookService */
    public $service;

    /**
     * Create a new controller instance.
     *
     * @param  \Kreatinc\Bot\Services\FacebookService $service
     * @return void
     */
    public function __construct(FacebookService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the bot information.
     *
     * @param  int  $botID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($botID)
    {
        $bot = Bot::with(['settings', 'intents', 'page'])->findOrFail($botID);

        return response()->json($bot);
    }

    /**
     * Add an intent bot.
     *
     * @param  int  $botID
     * @param  int  $intentID
     * @return \Illuminate\Http\JsonResponse
     */
    public function addIntent($botID, $intentID, AddBotIntentRequest $request)
    {
        $bot = Bot::findOrFail($botID);
        $intent = Intent::findOrFail($intentID);
        if ($intent->isListing()) {
            if (!$request->filled('listing_id') || !is_numeric($request->listing_id)) {
                return response()->json('The field listing_id is Required.', 400);
            }
            $bot->updateData($request->only(['listing_id']));
        }

        if ($bot->intents()->find($intentID)) {
            $bot->intents()->updateExistingPivot($intentID, $request->only(Intent::pivotFields()));
        } else {
            $bot->intents()->attach($intentID, $request->only(Intent::pivotFields()));
            BotHistory::addRaw($bot->id, 'conversation_type', $intent->name .' was added');
            $this->service->addPersistentMenu($bot);
        }
        return response()->json(true);
    }

    /**
     * remove an intent bot.
     *
     * @param  int  $botID
     * @param  int  $intentID
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeIntent($botID, $intentID)
    {
        $bot = Bot::findOrFail($botID);
        $intent = Intent::find($intentID);

        if ($bot->intents()->detach($intentID)) {
            BotHistory::addRaw($bot->id, 'conversation_type', ($intent->name ?? $intentID) .' was removed');
            $this->service->addPersistentMenu($bot);
        }
        return response()->json(true);
    }

    public function updateSettings($botID, BotSettingsRequest $request)
    {
        $bot = Bot::findOrFail($botID);

        $bot->settings->updateData($request->all());

        $this->service->client->setToken($bot->page->access_token);

        if ($bot->settings->wasChanged('presistent_menu')) {
            if ($bot->settings->presistent_menu) {
                $this->service->addPersistentMenu($bot);
            } else {
                try {
                    $this->service->client->removeProfileProperties(['persistent_menu']);
                } catch (\Exception $e) {
                    if (is_facebook_token_error($e)) {
                        $bot->page->access_token = null;
                        $bot->page->save();
                    }
                }
            }
        }

        if ($bot->settings->wasChanged('whitelisted_domains')) {
            try {
                if (! empty($bot->settings->whitelisted_domains)) {
                    $this->service->client->whitelistDomains($bot->settings->whitelisted_domains);
                } else {
                    $this->service->client->removeProfileProperties(['whitelisted_domains']);
                }
            } catch (\Exception $e) {
                if (is_facebook_token_error($e)) {
                    $bot->page->access_token = null;
                    $bot->page->save();
                }
            }
        }

        return response()->json($bot->settings);
    }

    /**
     * Add new bot.
     *
     * @param  CreateBotRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateBotRequest $request)
    {
        $this->service->client->setToken($request->page_token);

        $agent = Agent::where('l2l_member_id', $request->l2l_member_id)->firstOrFail();
        $agent->setL2LToken($request->l2l_token);

        if ($agent->hasReachedBotsLimit()) {
            return response()->json([
                'message' => 'You can\'t create more than '. config('bot.bots_limit') .' bots!',
                'code'    => 'bots_limit_reached',
            ], Response::HTTP_BAD_REQUEST);
        }

        if (Page::alreadyHasBot($request->page_id)) {
            return response()->json([
                'message' => 'This page already has a bot.',
                'code'    => 'duplicate_page',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Remove pages connected to disabled bots
        Page::where('account_id', $request->page_id)->delete();

        // Subscribe the page into our app.
        $this->service->client->addPage($request->page_id);

        $page = $agent->pages()->create([
            'account_id'   => $request->page_id,
            'access_token' => $request->page_token,
            'name'         => $request->page_name,
        ]);

        $bot = Bot::createForPage($page, $request->all());

        // Add Greeting message to the Facebook welcome screen
        $this->service->client->addGreetingText([
            'locale' => 'default',
            'text'   => $bot->getStartedMessage(),
        ], $bot->listing_id, $agent->l2l_token);

        return response()->json($bot);
    }

    /**
     * Update a bot.
     *
     * @param  int  $botID
     * @param  UpdateBotRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($botID, UpdateBotRequest $request)
    {
        $bot = Bot::findOrFail($botID);

        $bot->updateData($request->all());
        if (! $bot->page) {
            return response()->json([
                'message' => 'This bot has no active page.',
                'code'    => 'inactive_page',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->service->client->setToken($bot->page->access_token);

        $bot->page->agent->fill($request->only(['l2l_token']))->save();

        if ($bot->wasChanged('status')) {
            if ($bot->status) {
                $this->service->addPersistentMenu($bot);
            } else {
                $this->service->client->removeProfileProperties(['persistent_menu']);
            }
            $this->service->client->addGreetingText([
                'locale' => 'default',
                'text'   => $bot->getStartedMessage(),
            ], $bot->listing_id, $bot->page->agent->l2l_token);

        } elseif ($bot->wasChanged('greeting_text')) {
            try {
                $this->service->client->addGreetingText([
                    'locale' => 'default',
                    'text'   => $bot->getStartedMessage(),
                ], $bot->listing_id, $bot->page->agent->l2l_token);
            } catch (\Exception $e) {
                if (is_facebook_token_error($e)) {
                    $bot->page->access_token = null;
                    $bot->page->save();
                }
            }
        }

        return response()->json($bot);
    }

    /**
     * Delete a bot.
     *
     * @param  int  $botID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($botID)
    {
        $bot = Bot::findOrFail($botID);

        // Remove the bot from the page.
        if ($bot->status && $bot->page) {
            try {
                $this->service->removeFacebookPage([
                    'page_id' => $bot->page->account_id,
                ]);
            } catch (Exception $e) {
                \Log::warning(sprintf(
                    'Can\'t remove page: "%s" with id: "%s" from our application.',
                    $bot->page->name,
                    $bot->page->account_id
                ));
            }
        }

        if ($bot->page) {
            $bot->page->delete();
        }
        $bot->delete();

        return response()->json(true);
    }

    /**
     * Display the bot history.
     *
     * @param  int  $botID
     * @return \Illuminate\Http\JsonResponse
     */
    public function botHistory($botID)
    {
        $data = BotHistory::where('bot_id', $botID)
            ->orderBy('id', 'DESC')
            ->paginate(request('per_page', 20));

        return response()->json($data);
    }
}
