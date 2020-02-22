<?php

namespace Kreatinc\Bot\Libraries\Facebook;

use Illuminate\Support\Arr;

class ParseMessage
{
    /** @var string|array */
    private $message;

    /** @var null|string */
    private $type;

    /**
     * Create a new ParseMessage instance.
     *
     * @param  string  $message
     * @param  string  $type
     * @return void
     */
    public function __construct(string $message, ?string $type)
    {
        $this->message = $message;
        $this->type = $type;

        // The message body is a json string, so we need to decode it.
        if ($type === 'template' || $type === 'image') {
            $this->message = json_decode($message, true);
        }
    }

    /**
     * Parse the current message.
     *
     * @return array
     */
    public function parse(): array
    {
        // Text.
        if ($this->type === 'text') {
            return [
                'text' => $this->message,
            ];
        }

        // Template.
        if ($this->type === 'template') {
            $payload = Arr::get($this->message, 'attachments.0.payload');

            // Generic template.
            if (Arr::get($payload, 'template_type') === 'generic') {
                return [
                    'generic' => $this->parseGenericTempalte($payload),
                ];
            }
        }

        // Image
        if ($this->type === 'image') {
            $payload = Arr::get($this->message, 'attachments.0.payload');
            return [
                'image' => $this->parseImageAttachment($payload),
            ];
        }

        // This for unsupported messages.
        return [];
    }

    /**
     * Parse generic template message.
     *
     * @param  array  $payload
     * @return array
     */
    private function parseGenericTempalte($payload): array
    {
        $result = [];

        foreach (Arr::get($payload, 'elements', []) as $attachment) {
            $buttons = function ($attachment) {
                $buttons = [];
                foreach (Arr::get($attachment, 'buttons', []) as $button) {
                    $buttons[] = [
                        'url'   => $button['url'],
                        'title' => $button['title'],
                    ];
                }

                return $buttons;
            };

            $result[] = [
                'title'     => Arr::get($attachment, 'title'),
                'subtitle'  => Arr::get($attachment, 'subtitle'),
                'image_url' => Arr::get($attachment, 'image_url'),
                'buttons'   => $buttons($attachment),
            ];
        }

        return $result;
    }

    /**
     * Parse image attachment.
     *
     * @param  array  $payload
     * @return array
     */
    private function parseImageAttachment(array $payload): array
    {
        return [
            'url' => Arr::get($payload, 'url'),
        ];
    }
}
