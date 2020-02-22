<?php

namespace Kreatinc\Bot\Chat\Sender;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Kreatinc\Bot\Exceptions\SilentException;

trait PrepareValuation
{
    /**
     * Prepare Home Valuation data to send it.
     *
     * @return array|false
     */
    public function valuation()
    {
        // Conversation data.
        $data = $this->filterData(['name', 'email', 'email_again', 'street', 'zipcode', 'phone', 'contact_me', 'location', 'source']);

        if (filter_var(Arr::get($data, 'email_again'), FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $data['email_again'];
        } elseif (! filter_var(Arr::get($data, 'email'), FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $this->subscriber()->email;
        }

        // Home Valuation
        $address = [];
        $valuation = $this->homeValuationInformation(format_address($data));
        if (empty($valuation)) {
            // Address from user input.
            $address = [
                'street'  => Arr::get($data, 'street'),
                'zipcode' => Arr::get($data, 'zipcode'),
            ];
        } else {
            // Use the valuation address.
            $address = $valuation['address'];
        }

        return array_merge([
            'type' => 'seller',
            // Price
            'price' => (string) Arr::get($valuation, 'value.mid'),

            'property_type' => Arr::get($valuation, 'type'),
            'bedrooms'      => Arr::get($valuation, 'bedrooms'),
            'bathrooms'     => Arr::get($valuation, 'bathrooms'),
            'year_built'    => Arr::get($valuation, 'year_built'),
        ], $data, $address);
    }

    /**
     * Get Home Valuation
     *
     * @param  string $address
     * @return array
     */
    private function homeValuationInformation(string $address)
    {
        try { // API may return an error.
            $response = $this->client->get('homevaluation', ['address' => $address]);
        } catch (SilentException $e) {
            Log::error($e);

            return [];
        }

        // Return valuation only if the response has property field.
        if (Arr::has($response, 'property')) {
            $property = $response['property'][0];

            return [
                'address'    => Arr::get($property, 'address'),
                'value'      => Arr::get($property, 'value'),
                'type'       => Arr::get($property, 'type'),
                'bedrooms'   => Arr::get($property, 'bedrooms'),
                'bathrooms'  => Arr::get($property, 'bathrooms'),
                'year_built' => Arr::get($property, 'year_built'),
            ];
        }

        return [];
    }

    /**
     * Format date from string.
     *
     * @param  array  $data
     * @return void
     */
    protected function formatDate($value)
    {
        if (empty($value)) {
            return;
        }

        switch ($value) {
            case 'Tomorrow':
                return Carbon::parse($value)->format('Y-m-d H:i:s');
            case 'This weekend':
                return Carbon::now()->nextWeekendDay()->format('Y-m-d H:i:s');
            case 'Next Week':
                return Carbon::now()->addWeek(1)->nextWeekendDay()->format('Y-m-d H:i:s');
        }
        return $value;
    }

}
