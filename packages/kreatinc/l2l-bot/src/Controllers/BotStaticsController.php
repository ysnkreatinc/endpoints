<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Routing\Controller;
use Kreatinc\Bot\Services\FacebookService;

// Models
use Kreatinc\Bot\Models\Bot;

class BotStaticsController extends Controller
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
     * Fetch the bot statics.
     *
     * @param  int  $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function statics($bot)
    {
        $bot = Bot::findOrFail($bot);

        $statics = [
            'subscribers'   => $bot->subscribers()->count(),
            'leads'         => $bot->page->conversations()->where('completed', true)->count(),
            'messages'      => $bot->page->messages()->count(),
            'conversations' => $bot->page->conversations()->count(),
        ];

        return response()->json($statics);
    }
}
