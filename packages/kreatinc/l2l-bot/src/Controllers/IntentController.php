<?php

namespace Kreatinc\Bot\Controllers;

use Illuminate\Routing\Controller;
use Kreatinc\Bot\Models\Intent;

class IntentController extends Controller
{
    /**
     * All the bot types from the datastore.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            Intent::selectable()->get()
        );
    }
}
