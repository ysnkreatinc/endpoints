<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Kreatinc\Bot\Libraries\Facebook\ParseMessage;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'original_id',
        'sender_id',
        'is_page',
        'conversation_id',
        'body',
        'type',
        'timestamp'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['parsed_body'];

    /**
     * Create a message from the given data.
     *
     * @param  string  $original_id
     * @param  string  $sender_id
     * @param  bool    $is_page
     * @param  int     $conversation_id
     * @param  string  $body
     * @param  string  $type
     * @param  int     $timestamp
     * @return \Kreatinc\Bot\Models\Message
     */
    public static function createFromData(
        $original_id,
        $sender_id,
        $is_page,
        $conversation_id,
        $body,
        $type,
        $timestamp
    ) {
        return static::create(compact(
            'original_id',
            'sender_id',
            'is_page',
            'conversation_id',
            'body',
            'type',
            'timestamp'
        ));
    }

    public static function alreadyExists($sender_id, $timestamp)
    {
        return static::where('timestamp', $timestamp)
            ->where('sender_id', $sender_id)
            ->exists();
    }

    /**
     * Message Conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Parse the message body on the fly.
     *
     * @return mixed
     */
    public function getParsedBodyAttribute()
    {
        $parser = new ParseMessage($this->body, $this->type);

        return $parser->parse();
    }
}
