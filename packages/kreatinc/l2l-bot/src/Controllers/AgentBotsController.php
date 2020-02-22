<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Routing\Controller;

use Kreatinc\Bot\Models\Bot;

class AgentBotsController extends Controller
{
    /**
     * Create a new BotController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ...
    }

    /**
     * Agent Bots.
     *
     * @param  int  $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function bots($member)
    {
        $bots = Bot::with(['settings', 'intents', 'page'])
            ->where('l2l_member_id', $member)
            ->paginate();

        return response()->json($bots);
    }

    /**
     * Agent Bots by intent.
     *
     * @param  int  $member
     * @param  int  $intent
     * @return \Illuminate\Http\JsonResponse
     */
    public function botsByIntents($member, $intent)
    {
        $bots = Bot::with(['settings', 'intents', 'page'])
            ->where('l2l_member_id', $member)
            ->whereHas('intents', function ($query) use ($intent) {
                $query->where('intents.id', $intent);
            })
            ->paginate();

        return response()->json($bots);
    }
}
