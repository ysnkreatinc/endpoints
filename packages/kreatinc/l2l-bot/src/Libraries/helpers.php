<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

define('BUYER', 'buyer');
define('SELLER', 'seller');
define('VALUATION', 'valuation');


/*
|--------------------------------------------------------------------------
| HELPER FUNCTOIONS
|--------------------------------------------------------------------------
*/

/**
 * @param string $type
 * @return array
 */
function supported_entities_for($type)
{
    if (!is_string($type) || empty($type)) {
        return [];
    }
    switch ($type) {
        case 'intent': ;
        case 'type': return [$type,'buyer','seller','valuation','listing','intent'];

        case 'buyer': ;
        case 'seller': return [$type,'type'];

        case 'datetime': ;
        case 'time': ;
        case 'date': return ['datetime','time','date'];

        case 'phone_number': ;
        case 'phone': return ['phone','phone_number','number','confirm'];

        case 'email_phone': return [$type,'email','phone','phone_number'];

        case 'size': ;
        case 'living_area': return [$type,'size','area_size','number'];

        case 'bedrooms': ;
        case 'bathrooms': return [$type,'number'];

        case 'amount_of_money': ;
        case 'price': return ['amount_of_money','price','number'];

        case 'address': return [$type,'location'];

        case 'confirm': ;
        case 'number': ;
        case 'property': ;
        case 'location': ;
        case 'email': return [$type];

        default: return [$type];
    }
}

/**
 * Devided to multiple messages
 * @param string $text
 * @return array
 */
function devide_msg($text)
{
    if (is_string($text)) {
        return explode('|', $text);
    }
    return [];
}

/**
 * Parse the address with this format: street, city, state, zipcode
 * Example: 123 Main Street, New York, NY 90040
 *
 * @param  string  $input
 * @return array
 */
function parseAddress(string $input, $default = [])
{
    // Define the final result of the address.
    $address = [
        'street'  => Arr::get($default, 'street'),
        'city'    => Arr::get($default, 'city'),
        'state'   => Arr::get($default, 'state'),
        'zipcode' => Arr::get($default, 'zipcode'),
    ];

    // Split the address string.
    $split = explode(',', $input);

    // Street
    if (! empty($split[0])) {
        $address['street'] = $split[0];
    }

    // We may have only street and zipcode.
    // Ex: 123 main street, 95630
    if (count($split) === 2) {
        $address['zipcode'] = $split[1];
    } else {
        // City
        if (! empty($split[1])) {
            $address['city'] = $split[1];
        }
    }

    if (count($split) === 3) {
        // State OR Zipcode
        if (! empty($split[2])) {
            $sz = explode(' ', trim($split[2]));

            // State
            if (! empty($sz[0])) {
                $address['state'] = $sz[0];
            }

            // Zipcode
            if (! empty($sz[1])) {
                $address['zipcode'] = $sz[1];
            }
        }
    } else if (count($split) === 4) {
        // State
        if (! empty($split[2])) {
            $address['state'] = $split[2];
        }
        // Zipcode
        if (! empty($split[3])) {
            // Keep only numbers
            $address['zipcode'] = preg_replace("/[^0-9]/", "", $split[3]);
        }
    }

    // Trim address value.
    array_walk($address, function(&$value) {
        if(! is_null($value)) {
            $value = trim($value);
        }
    });

    return $address;
}

/**
 * Rename array key.
 *
 * @param  array   $source
 * @param  string  $key
 * @param  string  $newKey
 * @return boolean
 */
function renameArrayKey(array &$source, $key, $newKey)
{
    if (array_key_exists($key, $source)) {
        $source[$newKey] = $source[$key];
        unset($source[$key]);

        return true;
    }

    return false;
}

if (! function_exists('format_address')) {
    /**
     * Format the address from the given array.
     *
     * @param  array  $address
     * @param  array  $only
     * @return string
     */
    function format_address($address, $only = ['street', 'city', 'state', 'zipcode'])
    {
        $output = '';
        // Street
        if (! empty($address['street']) && in_array('street', $only)) {
            $output = $address['street'];
        }
        // City
        if (! empty($address['city']) && in_array('city', $only)) {
            $output .= ', '.$address['city'];
        }
        // State
        if (! empty($address['state']) && in_array('state', $only)) {
            $output .= ', '.$address['state'];
        }
        // Zipcode
        if (! empty($address['zipcode']) && in_array('zipcode', $only)) {
            $output .= ', '.$address['zipcode'];
        }

        return ltrim($output, ',');
    }
}

/**
 * Check if error message is due to Facebook token
 * @param Exception $e
 * @return boolean
 */
function is_facebook_token_error($e)
{
    $needles = ['access token', 'must be granted', 'Bad signature'];
    if (Str::contains($e->getMessage(), $needles)) {
        return true;
    }

    $tokenErrors = [
        Facebook\Exceptions\FacebookAuthenticationException::class,
    ];

    return ! is_null(Arr::first($tokenErrors, function ($type) use ($e) {
            return $e instanceof $type;
        }));
}