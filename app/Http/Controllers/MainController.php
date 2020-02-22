<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Kreatinc\Bot\Models\Page;
use Kreatinc\Bot\Models\Agent;
use Kreatinc\Bot\Models\Bot;
use Kreatinc\Bot\Services\FacebookService;
use Illuminate\Support\Arr;
use Kreatinc\Bot\Models\Filters\SubscribersFilters;

class MainController extends Controller
{

    public function __construct(FacebookService $service)
    {
        $this->service = $service;
    }

    public function listIntent()
    {        
        return view('listintent');
    }
    
    /******
     *  IMPORTANT TO READ
     * *** */
    public function botsPage(){

        $pages = $this->list();

        // The endpoint public/bot/facebook/bots/agent/{member} not not including the subscribers count 
        // so i used the with('subscribers') to get the subscribers list and count 'em in the view
        $result= Bot::where('l2l_member_id', 11)->with('subscribers')->get();
        return view('bots', compact(['pages', 'result']));
    
    }

    /**
     * This just for test it hardcoded by you. i just used it.
     */
    public function list()
    {   
        $myArr = [
            'l2l_member_id' => 11,
            'facebook_user_id' => 3693880870623784,
        ];

        try {
            list($pages, $agentID, $fbID) = $this->service->listFacebookPages($myArr);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

            return $pages = [
                'agent_id' => $agentID,
                'facebook_user_id' => $fbID,
                'pages' => $pages
            ];
    }

    /**
     * I put this logic just for test, nothing intersted in this function.
     */
    public function diconnectFacebook()
    {
        if (
            Agent::WHERE('l2l_member_id', 11)
                ->WHERE('access_token', '')
                ->FIRST()
        )
        return redirect()->back();

        try
        {
            $disconnectFacebook = Agent::WHERE(
                'l2l_member_id',  11
            )
            ->WHERE('account_id', 3693880870623784)
            ->DELETE();
        }
        catch(\Exception $e)
        {
            return redirect()->back();
        }

        return redirect()->back();
        
    }

    /*
    * By this function i found 'one to one' issue, pages table and bots table.
    */
    public function addBot(Request $request)
    {
        $explode = explode('@', $request->facebook_pages);
        $data = [
            'title' => $request->title,
            'listing_id' => 1,
            'page_id' => $explode[0],
            'page_name' => $explode[2],
            'page_token' => $explode[1],
            'l2l_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImVjMzRlYTEwNjQwODA4YTkzMjJiMTljZTk2M2RkZDBhYjE5YjQ4YzZmYmYyNzI3Y2MxYWQ1NGFkOTIzYmE5ZDg3YTZhOTA3OTBhNGIzMDIxIn0.eyJhdWQiOiIxMSIsImp0aSI6ImVjMzRlYTEwNjQwODA4YTkzMjJiMTljZTk2M2RkZDBhYjE5YjQ4YzZmYmYyNzI3Y2MxYWQ1NGFkOTIzYmE5ZDg3YTZhOTA3OTBhNGIzMDIxIiwiaWF0IjoxNTY5NDk4NzU4LCJuYmYiOjE1Njk0OTg3NTgsImV4cCI6MTYwMTEyMTE1OCwic3ViIjoiMTg4MTE5Iiwic2NvcGVzIjpbXX0.VS3tunJ2z5RrlRfKKKbljOz8Mwtb8CyRnRgQcQwKUQSeBbmUc9KlXpBPml-UIo5pf_O30Sz_XtBYjibEn10Pvw',
            'l2l_member_id' => 11,
            'greeting_text' => "Hey {{user_first_name}} 👋, thanks for joining us on Messenger! \nI'm happy to answer your questions about buying or selling a home. \nClick get started to start.",
            'facebook_user_id' => 3693880870623784

        ];


        $bot = Bot::CREATE($data);

            if ($bot)
                return $bot->id;
        else
            return 'not inserted';

    }

    /*
    * This function return a bots list, Code here is not structured, it just for Test
    */
    public function editBot()
    {
        $client = new \GuzzleHttp\Client();
        $result = $client->get('http://localhost/l2l-bot/public/bot/facebook/bots/55/subscribers');

        //result means subscribers by bot

        $result = $result->getBody();
        $result = (json_decode($result)->data);

        $client2 = new \GuzzleHttp\Client();
        $result2 = $client2->get('http://localhost/l2l-bot/public/bot/facebook/bots/55');
        /*
        I used to request here because i need form the second request only the bot intents
        */ 

        //result2 is a collection of intents
        $result2 = $result2->getBody();
        $result2 = json_decode($result2)->intents;

        $listOfIntent = array();
        foreach($result2 as $intent)
        {
            switch ($intent->slug)
            {
                case 'seller':
                    array_push($listOfIntent, 'seller');
                break;
                
                case 'buyer':
                    array_push($listOfIntent, 'buyer');
                break;

                case 'valuation':
                    array_push($listOfIntent, 'valuation');
                break;

                case 'listing':
                    array_push($listOfIntent, 'listing');
                break;
            }
        }
    
        return view('bot_edit', compact('result', 'listOfIntent'));
    }

}
