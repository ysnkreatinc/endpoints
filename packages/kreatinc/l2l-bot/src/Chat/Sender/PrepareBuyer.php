<?php

namespace Kreatinc\Bot\Chat\Sender;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait PrepareBuyer
{
    /**
     * Prepare the Buyer data to send it.
     *
     * @return array
     */
    public function buyer()
    {
        $data = $this->filterData(['name', 'email', 'phone', 'price', 'date', 'schedule', 'schedule_date', 'address', 'another_realtor', 'pre_qualified', 'location', 'source']);

        if (array_key_exists('email', $data)) {
            $validator = Validator::make(['email' => $data['email']], [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                $data['email'] = $this->subscriber()->email;
            }
        }

        $data['schedule'] = $this->formatDate(Arr::get($data, 'schedule_date'));

        renameArrayKey($data, 'date', 'moving_plan');

        if (isset($data['price'])) {
            $price = explode('-', $data['price']);
            $data['price'] = $data['min_price'] = preg_replace("/[^0-9.]/", '', $price[0]);
            $data['max_price'] = preg_replace("/[^0-9.]/", '', $price[1] ?? $price[0]);
        }

        $address = '';
        if (array_key_exists('address', $data)) {
            if (count(explode(',', $data['address'])) === 1 ) { // City
                $address = parseAddress('', [
                    'city' => $data['address']
                ]);
            } else {
                $address = parseAddress($data['address']);
            }
            unset($data['address']);
        }

        // Set the address from the datastore if we are in Listing Bot.
        if ($this->conversation->intent->slug === 'listing') {
            try {
                $listing = $this->client->get("listings/{$this->conversation->page->bot->listing_id}", [
                    'leadForm' => 1
                ]);
                $address = $listing['address'];
            } catch (\Exception $e) {
                \Log::error("Listing");
                \Log::error($e->getMessage());
            }
        }

        return array_merge([
            'type' => 'buyer',

            'street'  => $address['street'] ?? '',
            'city'    => $address['city'] ?? '',
            'state'   => $address['state'] ?? '',
            'zipcode' => $address['zipcode'] ?? '',
        ], $data);
    }
}
