<?php

namespace Kreatinc\Bot\Chat\Sender;
use Illuminate\Support\Facades\Validator;

trait PrepareSeller
{
    /**
     * Prepare the Seller data to send it.
     *
     * @return array
     */
    public function seller()
    {
        $data = $this->filterData([
            'name',
            'email',
            'phone',
            'price',
            'property',
            'address',
            'date',
            'importance',
            'occupancy',
            'bedrooms',
            'bathrooms',
            'location',
            'source',
        ]);

        // Email
        if (array_key_exists('email', $data)) {
            // Validate the email before we send it.
            $validator = Validator::make(['email' => $data['email']], [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                $data['email'] = $this->subscriber()->email;
            }
        }

        $data['bedrooms'] = $this->getNumber($data['bedrooms'] ?? '0');
        $data['bathrooms'] = $this->getNumber($data['bathrooms'] ?? '0');

        // Rename property field.
        renameArrayKey($data, 'property', 'property_type');

        // Date as Moving Plan
        renameArrayKey($data, 'date', 'moving_plan');

        if (isset($data['price'])) {
            $price = explode('-', $data['price']);
            $data['price'] = $data['min_price'] = preg_replace("/[^0-9.]/", '', $price[0]);
            $data['max_price'] = preg_replace("/[^0-9.]/", '', $price[1] ?? $price[0]);
        }

        // Parse address
        $address = parseAddress($data['address'] ?? '');
        unset($data['address']);

        return array_merge([
            'type'    => 'seller',
            'street'  => $address['street'] ?? '',
            'city'    => $address['city'] ?? '',
            'state'   => $address['state'] ?? '',
            'zipcode' => $address['zipcode'] ?? '',
        ], $data);
    }

    protected function getNumber($value)
    {
        $number = (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        return $number ?: $value;
    }
}
