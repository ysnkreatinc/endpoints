<?php

namespace Kreatinc\Bot\Libraries;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;

class Wit
{
    protected $http;

    protected $token;

    protected $api;

    protected $version;

    public function __construct()
    {
        $this->api = config('bot.wit.api');
        if (empty($this->api)) {
            $this->api = 'https://api.wit.ai';
        }
        $this->version = config('bot.wit.version');
        $this->token = config('bot.wit.access_token');
        $this->http = new HttpClient(['base_uri' => $this->api]);
    }

    public function hasEntity(string $text, string $entity)
    {
        return Arr::has(
            $this->get('message', ['q' => $text]),
            "entities.{$entity}"
        );
    }

    public function getMessageIntent($text, array $params = [])
    {
        // get only the first 280 from the message to avoid WIT lenght exception
        $text = substr($text, 0, 279);
        $data = $this->get('message', ['q' => $text]);

        $intent = $text;
        $entity = null;

        // TODO create Domain classes for these values

        foreach (Arr::get($data, 'entities', []) as $witEntity => $d) {
            if (in_array($witEntity, ['on_off', 'sentiment', 'greetings'])) {
                continue;
            }
            $entity = $witEntity;
            if ($intent = Arr::get($d, '0.value')) {
                $intent .= Arr::get($d, '0.unit');
                break;
            } elseif (Arr::get($d, '0.type') === 'interval') {
                $intent = Arr::get($d, '0.from.value') . ' to ' . Arr::get($d, '0.to.value') . Arr::get($d, '0.to.unit');
                break;
            } elseif ($intent = Arr::get($d, '0.resolved.values.0.name')) {
                $intent .= ': (lat - long) ' . Arr::get($d, '0.resolved.values.0.coords.lat') . ' - ' . Arr::get($d, '0.resolved.values.0.coords.long');
                break;
            }
        }

        return [$intent, $entity];
    }

    public function get($endpoint, array $params = [])
    {
        return $this->api($endpoint, ['query' => $params], 'GET');
    }

    public function post($endpoint, array $params = [])
    {
        return $this->api($endpoint, ['json' => $params], 'POST');
    }

    protected function api($endpoint, $options, $method = 'GET')
    {
        if (empty($this->token)) {
            throw new \Exception('You must provide your WIT API token to make any API requests');
        }

        $options['headers'] = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ];
        Arr::set($options, 'query.v', $this->version);

        if ($method === 'GET') {
            $res = $this->http->get($endpoint, $options);
        } elseif ($method === 'POST') {
            $res = $this->http->post($endpoint, $options);
        } else {
            throw new \Exception('UNDEFINED HTTP METHOD');
        }

        return json_decode($res->getBody()->getContents(), true);
    }
}
