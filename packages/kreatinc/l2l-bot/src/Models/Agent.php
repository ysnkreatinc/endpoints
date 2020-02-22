<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $table = 'agents';

    protected $fillable = ['account_id','access_token','first_name','last_name','email','phone','l2l_token', 'l2l_member_id'];

    protected $appends = [
        'token_expired',
    ];

    /**
     * Find The User by his social account ID
     */
    public static function findByAccountID($ID)
    {
        return static::where('account_id', $ID)->firstOrFail();
    }

    public function setL2LToken($token)
    {
        $this->l2l_token = $token;
        $this->save();

        return $this;
    }

    public function setL2LMemberID($memberID)
    {
        $this->l2l_member_id = $memberID;
        $this->save();

        return $this;
    }

    public function getTokenExpiredAttribute()
    {
        $token = $this->access_token ?? null;

        return empty($token);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function bots()
    {
        return $this->hasMany(Bot::class, 'l2l_member_id', 'l2l_member_id');
    }

    public function hasReachedBotsLimit()
    {
        return $this->bots->count() >= config('bot.bots_limit');
    }

    public function accounts()
    {
        return $this->hasMany(AgentAccount::class);
    }
}
