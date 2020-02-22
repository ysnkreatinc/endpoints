<?php

namespace Kreatinc\Bot\Chat\Sender;

trait SenderData
{
    /**
     * Get the conversation data that will be sent to the API.
     *
     * @return array
     */
    public function data()
    {
        // Get all the conversation data.
        $data =  $this->conversation->leadData->flatMap(function ($item) {
            return [
                ($item->key ?? $item->leadField->entity_key) => $item->value
            ];
        })->toArray();

        // We merge the conversation data with other common fields.
        $results = array_merge($data, [
            'name' => join(' ', [
                $this->subscriber()->first_name,
                $this->subscriber()->last_name
            ]),
            'location' => sprintf('%s - %s', $this->bot->title, $this->page()->name),
            'source'   => $this->bot->title,
        ]);

        return $results;
    }

    /**
     * Filter the conversation data by the field id's.
     *
     * @param  array  $keys
     * @return array
     */
    public function filterData(array $keys = [])
    {
        return array_filter($this->data, function ($key) use($keys) {
            return in_array($key, $keys, true);
        }, ARRAY_FILTER_USE_KEY);
    }
}
