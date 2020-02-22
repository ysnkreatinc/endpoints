<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Kreatinc\Bot\Models\Bot;
use Kreatinc\Bot\Models\Conversation;

class AnalyticsController extends Controller
{
    /**
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leadsAnalytics(Request $request)
    {
        $total = Conversation::where('completed', true)
            ->where(function ($q) use ($request) {
                if ($request->filled('date_from')) {
                    $q->where('closed_at', '>', $request->get('date_from'));
                }
                if ($request->filled('date_to')) {
                    $q->where('closed_at', '<', $request->get('date_to'));
                }
                if ($request->filled('intent_id')) {
                    $q->where('intent_id', $request->get('intent_id'));
                }
            });

        if ($request->filled('bot_id')) {
            $total->whereHas('page.bot', function ($q) use ($request) {
                $q->where('bots.id', $request->get('bot_id'));
            });
        }
        if ($request->filled('l2l_member_id')) {
            $total->whereHas('page.bot', function ($q) use ($request) {
                $q->where('bots.l2l_member_id', $request->get('l2l_member_id'));
            });
        }

        return response()->json([
            'total' => $total->count()
        ]);
    }

    public function leadsConversations(Request $request)
    {
        $total = Conversation::where(function ($q) use ($request) {
                if ($request->filled('date_from')) {
                    $q->where('created_at', '>', $request->get('date_from'));
                }
                if ($request->filled('date_to')) {
                    $q->where('created_at', '<', $request->get('date_to'));
                }
                if ($request->filled('intent_id')) {
                    $q->where('intent_id', $request->get('intent_id'));
                }
            });

        if ($request->filled('bot_id')) {
            $total->whereHas('page.bot', function ($q) use ($request) {
                $q->where('bots.id', $request->get('bot_id'));
            });
        }
        if ($request->filled('l2l_member_id')) {
            $total->whereHas('page.bot', function ($q) use ($request) {
                $q->where('bots.l2l_member_id', $request->get('l2l_member_id'));
            });
        }

        return response()->json([
            'total' => $total->count()
        ]);
    }

    public function leadsBots(Request $request)
    {
        if ($request->filled('sort')) {
            $sort = $request->get('sort');
            $order = $request->get('order', 'asc');
        } else {
            $sort = 'bots.id';
            $order = $request->get('order', 'desc');
        }

        $data = Bot::orderBy($sort, $order)
            ->where(function ($q) use ($request) {
                foreach ($request->only(Bot::$filter_fields) as $key => $value) {
                    if ($key === 'title') {
                        $q->where($key, 'LIKE', '%'. $value .'%');
                    } else {
                        $q->where($key, $value);
                    }
                }
                foreach ($request->only(Bot::$custom_filters) as $key => $value) {
                    $q->{'filter'.Str::camel($key)}($value);
                }
            });

        return response()->json([
            'data'   => $data->paginate($request->get('per_page', 20))
        ]);
    }
}
