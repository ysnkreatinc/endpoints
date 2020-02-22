<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class BotHistory extends Model
{
    protected $table = 'bots_history';

    protected $fillable = [
        'bot_id',
        'field',
        'new_value',
        'description',
    ];

    public static function addRaw($bot_id, $field, $new_value, $description = null)
    {
        return static::create([
            'bot_id' => $bot_id,
            'field'  => $field,
            'new_value'   => $new_value,
            'description' => $description,
        ]);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }
}
