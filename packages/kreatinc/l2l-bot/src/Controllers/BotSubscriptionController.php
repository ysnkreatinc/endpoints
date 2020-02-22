<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Kreatinc\Bot\Services\FacebookService;

// Models
use Kreatinc\Bot\Models\Bot;

class BotSubscriptionController extends Controller
{
    /** @var \Kreatinc\Bot\Services\FacebookService */
    public $service;

    /**
     * Create a new BotController instance.
     *
     * @param  \Kreatinc\Bot\Services\FacebookService $service
     * @return void
     */
    public function __construct(FacebookService $service)
    {
        $this->service = $service;
    }

    /**
     * Subscribe the bot page from application.
     *
     * @param  int  $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($bot)
    {
        $bot = Bot::findOrFail($bot);

        // If the bot not belong to the current active account.
        // Don't subscribe the bot again.
        if (! $bot->active) return;

        $this->service->subscribePage($bot->page);

        $bot->update([
            'status' => true,
        ]);
        return response()->json(true);
    }

    /**
     * Unsubscribe the bot page from application.
     *
     * @param  int  $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe($bot)
    {
        $bot = Bot::findOrFail($bot);

        $this->service->unsubscribePage($bot->page);

        $bot->update([
            'status' => false,
        ]);
        return response()->json(true);
    }

    /**
     * Unsubscribe many bot pages at once.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function unsubscribeMany(Request $request)
    {
        $request->validate([
            'bots' => 'required|array',
        ]);

        Bot::findMany($request->bots)->each(function ($bot) {
            $this->service->unsubscribePage($bot->page);
            $bot->update([
                'status' => false,
            ]);
        });
        return response()->json(true);
    }
}
