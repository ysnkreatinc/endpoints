<?php
return [
    /**
     * Bots limit
     */
    'bots_limit' => env('BOTS_LIMIT', 5),

    /**
     * wit configuration
     */
    'wit' => [
        'access_token'  => env('WIT_ACCESS_TOKEN'),
        'version'       => env('WIT_VERSION'),
        'api'           => env('WIT_API', 'https://api.wit.ai')
    ],

    /**
     * Facebook configuration
     * Messenger verify token: will be used when messenger try to verify the
     * webhook.
     */
    'facebook' => [
        'app' => [
            'id'            => env('FACEBOOK_APP_ID'),
            'secret'        => env('FACEBOOK_APP_SECRET'),
            'graph_version' => env('FACEBOOK_APP_GRAPH_VERSION'),
            'redirect'      => env('FACEBOOK_APP_REDIRECT_URI'),
            'logout-redirect'      => env('FACEBOOK_APP_LOGOUT_REDIRECT_URI'),
        ],
        'messenger' => [
            'access_token' => env('MESSENGER_ACCESS_TOKEN'),
            'verify_token' => env('MESSENGER_VERIFY_TOKEN'),
        ],
    ],

    /**
     * L2L API configuration
     */
    'l2l' => [
        'api' => env('L2L_API', 'https://beta.staging.listingstoleads.com/api/'),
        'access_token' => env('L2L_ACCESS_TOKEN')
    ],

    /**
     * L2L API configuration
     */
    'sentences' => [
        'greeting' => [
            'general-all' => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home, give you a free home value estimate or show you more information about *{{listing_address}}*.|What describes you best?",
            'general'   => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home or give you a free home value estimate.|What describes you best?",
            'buyer'     => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home or give you a free home value estimate.|What describes you best?",
            'seller'    => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home or give you a free home value estimate.|What describes you best?",
            'valuation' => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home or give you a free home value estimate.|What describes you best?",
            'listing'   => "Hey {{user_first_name}}! 👋 I'm your bot assistant 🤖 from {{page}}.|I'd be happy to help you buy or sell a home, give you a free home value estimate or show you more information about *{{listing_address}}*.|What describes you best?",
        ],
        'closing' => 'I\'ll be here if you need anything else.',
        'stopping' => 'Roger that! The automated bot 🤖 stopped.',
        'restarting' => 'Understood! I will restart the conversation.',
        'request_agent' => 'Great! Our *{{page}}* representative will get back to you here ASAP.',
        'error_level_1' => 'Sorry, I didn\'t understand that.',
        'error_level_2' => 'Sorry! I\'m just a Bot 🤖! I didn\'t get that again.|Would you like to talk to a human instead or just skip this question?',
        'quick_replies' => [
            'confirm_continue' => 'Confirm & Continue',
            'request_agent' => 'Talk to a human',
            'skip' => 'Skip',
            'restart' => 'Restart',
        ],
    ],
    'placeholders' => [
        'zipcode_text' => 'Zip code',
        'footage_unit' => 'square footage',
    ],
];
