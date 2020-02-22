<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'name',
        'access_token',
        'agent_id',
        'bot_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'conversations',
    ];

    /**
     * Find The Page by its social account ID
     */
    public static function findByAccountID($ID)
    {
        return static::where('account_id', $ID)->firstOrFail();
    }

    public static function createOrRestore($account_id, $token, $name, $agent_id)
    {
        $page = static::where('account_id', $account_id)
                        ->withTrashed()
                        ->first();

        if (is_null($page)) {
            $page = static::firstOrNew([
                'account_id' => $account_id
            ]);
        }
        $page->fill([
            'access_token' => $token,
            'name'         => $name,
            'agent_id'     => $agent_id,
        ]);
        $page->deleted_at = null;
        $page->save();

        return $page;
    }

    /**
     * Close any active conversation.
     *
     * @return void
     */
    public function closeActiveConversations()
    {
        $this->conversations()->whereNull('closed_at')->update([
            'closed_at' => now(),
        ]);
    }

    /**
     * Set the bot id into the page.
     *
     * @param  int  $id
     * @return \Kreatinc\Bot\Models\Page
     */
    public function setBotID($id)
    {
        $this->bot_id = $id;
        $this->save();

        return $this;
    }

    /**
     * Checks if there a bot already has the given page id.
     *
     * @param  string $page_id
     * @return bool
     */
    public static function alreadyHasBot(string $page_id)
    {
        return static::whereHas('bot', function ($query) {
            // $query->where('status', true);
        })->where('account_id', $page_id)->exists();
    }

    /**
     * Page Agent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Page Conversations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Page Bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    /**
     * Page messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function messages()
    {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }
}
