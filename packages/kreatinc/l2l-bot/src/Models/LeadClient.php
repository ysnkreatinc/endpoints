<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

use Kreatinc\Bot\Models\Filters\Filterable;

class LeadClient extends Model
{
    use SoftDeletes, Filterable;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bot_id',
        'account_id',
        'sender_id',
        'first_name',
        'last_name',
        'email',
        'profile_pic',
        'phone',
        'address',
        'type',
    ];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['bot'];

    /**
     * Find The User by his social account ID
     */
    public static function findByAccountID($ID)
    {
        return static::where('account_id', $ID)->first();
    }

    public static function createFromData($userData)
    {
        $data = [
            'account_id' => $userData['id'],
            'first_name' => $userData['first_name'],
            'last_name'  => $userData['last_name']
        ];

        return static::create($data);
    }

    public function isFirstInWhile($messageID)
    {
        return ! $this->messages()
                            ->where('messages.id', '!=', $messageID)
                            ->where('messages.created_at', '>', Date::parse('- 38 hours'))
                            ->exists();
    }

    public function hasStoppedTheBot()
    {
        return $this->bot_stopped;
    }

    public function stopTheBotPermanently()
    {
        $this->bot_stopped = true;
        $this->save();

        $this->conversations()
            ->whereNull('closed_at')
            ->update(['closed_at' => now()]);
    }

    public function turnOnTheBot()
    {
        $this->bot_stopped = false;

        $this->save();
    }

    /**
     * Update subscriber data.
     *
     * @param  array  $data
     * @return void
     */
    public function syncData(array $data)
    {
        $newData = [];
        $append = function(&$newData, $data, $key) {
            // Address
            if ($key === 'address') {
                $newData['address'] = sprintf('%s %s %s %s',
                    $data['street'] ?? '',
                    $data['city'] ?? '',
                    $data['state'] ?? '',
                    $data['zipcode'] ?? ''
                );
                return;
            }

            if (! empty($data[$key])) {
                $newData[$key] = $data[$key];
            }
        };

        $append($newData, $data, 'email');
        $append($newData, $data, 'phone');
        $append($newData, $data, 'address');
        $append($newData, $data, 'type');

        $this->update($newData);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }

    /**
     * Client Bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function transform()
    {
        return [
            'id' => $this->id,
            'last_name'   => $this->last_name,
            'first_name'  => $this->first_name,
            'account_id'  => $this->account_id,
            'profile_pic' => $this->profile_pic,
        ];
    }
}
