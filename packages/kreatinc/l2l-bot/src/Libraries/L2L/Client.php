<?php

namespace Kreatinc\Bot\Libraries\L2L;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Client
{
    /**
     * @var HttpClient HTTP Client
     */
    protected $http;

    protected $token;

    protected $api;

    public function __construct()
    {
        // $this->token = config('bot.l2l.access_token');
        $this->api = config('bot.l2l.api');
        $this->http = new HttpClient(['base_uri' => $this->api]);
    }

    public function token($token)
    {
        $this->token = $token;

        return $this;
    }

    public function post_lead($data)
    {
        return $this->post('lead', []);
    }

    /**
     * Search for Listings In Listings To Leads API.
     *
     * @param  array  $params['address'] - The Listing address the user want to find.
     * @param  array  $params['per_page'] - How many Listings do you want to search for.
     *
     * @param  mixed[] $params {
     *      @type string $address
     *      @type int    $per_page
     * }
     * @return array
     */
    public function searchListingsBy(array $params)
    {
        $template = 'I have {number} houses in {city} that you may be interested in.';

        // Check if we have an address, and it's not empty.
        if (empty($params['address'])) {
            return [[], ''];
        }

        // Search for listings in Listins To Leads API..
        $response = $this->get('listings', [
            'city'     => $params['address'],
            'per_page' => $params['per_page'] ?? 5,
            'leadForm' => 1,
            'active_listings' => 1,
        ]);

        if (empty($response['data'])) {
            return [[], ''];
        }

        // Replace the number with the listings length.
        $template = Str::replaceFirst('{number}', count($response['data']), $template);
        $template = Str::replaceFirst('{city}', $params['address'], $template);

        return [$response['data'], $template];
    }

    /**
     * Get "Home Valuation" from "Listings To Leads" API and format the data.
     *
     * @param  string  $address
     * @return array
     */
    public function get_valuation($address)
    {
        $content = $this->get('homevaluation', ['address' => $address]);

        if (! isset($content['property'])) {
            \Log::error('L2L API ERROR - Content', [$content]);
            throw new \Exception('L2L API returned an error status');
        }

        return $this->formatValuation($content['property'][0]);
    }

    /**
     * Format "Home Valuation" data.
     *
     * @param  array  $data
     * @return array
     */
    protected function formatValuation($data)
    {
        $format = [];
        $formatString = '🏡 ' . implode(', ', $data['address']) . "\n";
        // Bedrooms
        if (!empty($data['bedrooms'])) {
            $formatString .= "🛏️ *{$data['bedrooms']}* Bedrooms\n";
        }
        // Bathrooms
        if (!empty($data['bathrooms'])) {
            $formatString .= "🛁 *{$data['bathrooms']}* Bathrooms\n";
        }
        $format[] = $formatString;

        // Property Value
        if (isset($data['value'])) {
            $valueString = sprintf("💰 The median value of your home is about *$%s* approximately\n", Arr::get($data, 'value.mid'));
            $low = Arr::get($data, 'value.low');
            if (!empty($low) && $low != '0') {
                $valueString .= sprintf("The lowest estimation is *$%s*,\n", Arr::get($data, 'value.low'));
            }
            $high = Arr::get($data, 'value.high');
            if (!empty($high) && $high != '0') {
                $valueString .= sprintf("and the highest is *$%s*.", Arr::get($data, 'value.high'));
            }
            $format[] = $valueString;
        }

        return $format;
    }

    /**
     * Get the listing information.
     *
     * @param int  $id
     * @return array
     */
    public function listingInformation($id)
    {
        $result = [];
        $listing = $this->get("listings/{$id}", [
            'leadForm' => 1,
        ]);
        $result['address'] = format_address($listing['address'], ['street', 'city', 'state']);

        $result['price']         = $listing['features']['price'];
        $result['bedrooms']      = $listing['features']['bedrooms'];
        $result['bathrooms']     = $listing['features']['bathrooms'];
        $result['lot_size']      = $listing['features']['lot_size'];
        $result['lot_size_unit'] = $listing['features']['lot_size_unit'];
        $result['living_area']      = $listing['features']['living_area'];
        $result['living_area_unit'] = $listing['features']['living_area_unit'];
        $result['description']   = $listing['description'];
        $result['photos']        = $listing['photos'];
        $result['url']           = $listing['url'];

        return $result;
    }

    public function get($endpoint, array $params = [])
    {
        return $this->api($endpoint, ['query' => $params], 'GET');
    }

    public function post($endpoint, array $params = [])
    {
        return $this->api($endpoint, ['json' => $params], 'POST');
    }

    /**
     * Put request.
     *
     * @param  string $endpoint
     * @param  array  $params
     * @return array
     */
    public function put($endpoint, array $params = [])
    {
        return $this->api($endpoint, ['json' => $params], 'PUT');
    }

    protected function api($endpoint, $options, $method = 'GET')
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your L2L API token to make any API requests');
        }

        $options['headers'] = [
            // 'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ];

        if ($method === 'GET') {
            $res = $this->http->get($endpoint, $options);
        } elseif ($method === 'POST') {
            $res = $this->http->post($endpoint, $options);
        } elseif ($method === 'PUT') {
            $res = $this->http->put($endpoint, $options);
        } else {
            throw new \Exception('UNDEFINED HTTP METHOD');
        }

        return json_decode($res->getBody()->getContents(), true);
    }
}
