<?php

namespace Kreatinc\Bot\Libraries\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ActionsManager
{
    protected $available_actions = [
        'buyer_suggestions',
        'show_listing',
        'home_valuation',
    ];

    protected $actions;

    protected $chat;

    public function __construct($chat, string $actions)
    {
        $this->chat = $chat;
        $this->actions = explode('|', $actions);
    }

    public static function make($chat, string $actions)
    {
        return new static($chat, $actions);
    }

    public function doAll()
    {
        if (empty($this->actions)) {
            return false;
        }

        foreach ($this->actions as $action) {
            if (!in_array($action, $this->available_actions)) {
                continue;
            }
            $this->{Str::camel('action_'. $action)}();
        }
        return true;
    }

    /**
     * Listing information
     *
     * @return void
     */
    private function actionShowListing()
    {
        try {
            $listing = $this->chat->l2lClient->listingInformation($this->chat->bot->listing_id);
        } catch (\Exception $e) {
            \Log::error('ShowListing ERROR:');
            \Log::error($e->getMessage());
            return ;
        }
        $this->chat->messagingTool->text('Perfect! 💪 Please check the information of this property below:')->send();

        $listingInfo = sprintf("🏡 %s\n💲 %s\n", $listing['address'], $listing['price']);
        if (! empty($listing['bedrooms'])) {
            $listingInfo .= sprintf("🛏️ %s bedrooms\n", $listing['bedrooms']);
        }
        if (! empty($listing['bathrooms'])) {
            $listingInfo .= sprintf("🛁 %s bathrooms\n", $listing['bathrooms']);
        }
        $this->chat->messagingTool->text($listingInfo)->send();

        $this->chat->messagingTool->text('This property has too many good details to list here. Feel free to click ‘View ALL details’ to check all the photos, details, school information and more!')->send();

        $this->chat->messagingTool->addCard([
            'title'     => $listing['address'],
            'subtitle'  => $listing['description'],
            'image_url' => $listing['photos'][0]['url'] ?? 'https://photos.listingstoleads.com/property/no-images-are-available.png',
            'buttons' => [
                [
                    'title' => 'View ALL Details!',
                    'type' => 'web_url',
                    'url' => $listing['url'],
                    'webview_height_ratio' => 'tall',
                ],
            ],
        ])->send();

        $this->chat->conversation->storeLeadDataByKey('show_listing', 'exists');
    }

    /**
     * Listings Suggestions.
     *
     * @return void
     */
    private function actionBuyerSuggestions()
    {
        if ($this->chat->bot->settings->listings_suggestions === false) {
            return;
        }
        // TODO: Support address: street, city, state zipcode.
        $address = $this->chat->conversation->getDataByKey('address');

        [$listings, $templateText] = $this->chat->l2lClient->searchListingsBy(['address' => $address]);
        if (empty($listings)) {
            return;
        }

        $this->chat->messagingTool->text($templateText)->send();

        foreach ($listings as $listing) {
            $this->chat->messagingTool->addCard([
                'title'     => $listing['address']['street'],
                'subtitle'  => $listing['description'],
                'image_url' => $listing['photos'][0]['url'] ?? 'https://photos.listingstoleads.com/property/no-images-are-available.png',
                'buttons' => [
                    [
                        'title' => 'View ALL Details!',
                        'type' => 'web_url',
                        'url' => $listing['url'],
                        'webview_height_ratio' => 'tall',
                    ],
                ],
            ]);
        }
        $this->chat->messagingTool->send();
        $this->chat->conversation->storeLeadDataByKey('buyer_suggestions', 'exists');
    }

    private function actionHomeValuation()
    {
        $address = format_address([
            'street'  => $this->chat->conversation->getDataByKey('street'),
            'zipcode' => $this->chat->conversation->getDataByKey('zipcode'),
        ]);

        try {
            $valuation = $this->chat->l2lClient->get('homevaluation', ['address' => $address]);
            // If we can't find a valuation send a message.
            // Also close the conversation.
            // Also check if the valuation have a "value".
            if (
                ! Arr::has($valuation, 'property.0.value.low')
                || ! Arr::has($valuation, 'property.0.value.high')
            ) {
                throw new \Exception('Can\'t find valuation.');
            }
        } catch (\Exception $e) {
            \Log::error('Home Valuation ERROR:');
            \Log::error($e->getMessage());
            return ;
        }

        $price = Arr::get($valuation, 'property.0.value');
        $this->chat->messagingTool->text('Perfect! 👌Based on recent home sales, but without seeing the home personally, the home value estimate would be between:')->send();
        $this->chat->messagingTool->text(sprintf(
            'A low of $%s and a high of $%s. 💰',
            number_format($price['low']),
            number_format($price['high'])
        ))->send();

        $this->chat->conversation->storeLeadDataByKey('home_valuation', 'exists');
    }
}
