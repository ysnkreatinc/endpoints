<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Bot extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'title',
        'l2l_member_id',
        'listing_id',
        'facebook_user_id',
        // 'page_id',
        'greeting_text',
        'intro_text',
        'closing_text',
    ];

    /**
     * The attributes that can be filtered.
     *
     * @var array
     */
    public static $filter_fields = [
        'status',
        'title',
        'l2l_member_id',
        'listing_id',
        'facebook_user_id'
    ];

    /**
     * The custom filters.
     *
     * @var array
     */
    public static $custom_filters = [
        'intent_id',
        'date_from',
        'date_to',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'conversations',
        'token_expired',
        'leads',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status'        => 'boolean',
        'l2l_member_id' => 'integer',
        'listing_id'    => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        self::updated(function ($bot) {
            if ($bot->wasChanged('status')) {
                BotHistory::addRaw($bot->id, 'status', $bot->status, $bot->status ? 'was enabled':'was disabled');
            }
            foreach (Arr::except($bot->getChanges(), ['status','greeting_text','updated_at']) as $key => $value) {
                BotHistory::addRaw($bot->id, $key, $value);
            }
        });
    }

    public static function createForPage(Page $page, array $data)
    {
        $bot = new self();
        $bot->fill($data);
        $bot->status = true;
        $bot->page_id = $page->id;
        $bot->greeting_text = !empty($bot->intro_text) ? $bot->intro_text : config('bot.sentences.greeting.general');
        $bot->save();

        $page->bot_id = $bot->id;
        $page->save();

        $bot->settings()->updateOrCreate([], []);

        return $bot;
    }

    public function updateData(array $data)
    {
        $this->fill($data);
        $this->greeting_text = $this->getGreeting();
        $this->save();

        return $this;
    }

    public function scopeFilterIntentId($query, $intents)
    {
        if (!is_array($intents)) {
            $intents = explode(',', $intents);
        }
        return $query->whereHas('intents', function ($q) use ($intents) {
            $q->whereIn('intents.id', $intents);
        });
    }

    public function scopeFilterDateFrom($query, $date)
    {
        if (empty($date)) {
            return $query;
        }
        return $query->where('created_at', '>', $date);
    }

    public function scopeFilterDateTo($query, $date)
    {
        if (empty($date)) {
            return $query;
        }
        return $query->where('created_at', '<', $date);
    }

    /**
     * Get total bot page conversations.
     *
     * @return int
     */
    public function getConversationsAttribute()
    {
        return $this->page->conversations->count();
    }

    public function getTokenExpiredAttribute()
    {
        $token = $this->page->access_token ?? null;

        return empty($token);
    }

    /**
     * Check if the current bot belongs to the current active Facebook account.
     *
     * @return bool
     */
    public function getActiveAttribute()
    {
        return $this->page->agent->account_id === $this->facebook_user_id;
    }

    /**
     * Get total bot page leads.
     *
     * @return int
     */
    public function getLeadsAttribute()
    {
        return $this->page->conversations->where('completed', true)->count();
    }

    /**
     * Bot page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }

    public function intents()
    {
        return $this->belongsToMany(Intent::class, 'bot_intents')->withPivot(Intent::pivotFields());
    }

    public function selectableIntents()
    {
        return $this->belongsToMany(Intent::class, 'bot_intents')->where('selectable', true)->withPivot(Intent::pivotFields());
    }

    /**
     * Bot Settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne(BotSetting::class);
    }

    /**
     * Bot Subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscribers()
    {
        return $this->hasMany(LeadClient::class);
    }

    public function history()
    {
        return $this->hasMany(BotHistory::class);
    }

    public function hasSingleIntent()
    {
        return $this->selectableIntents->count() === 1;
    }

    public function hasNoIntents()
    {
        return $this->selectableIntents->isEmpty();
    }

    public function getGreeting()
    {
        if ($this->hasSingleIntent()) {
            $intent = $this->selectableIntents->first()->getWitValue();
        } elseif ($this->isAcceptedIntent('listing')) {
            $intent = 'general-all';
        } else {
            $intent = 'general';
        }

        return $this->intro_text ?? config('bot.sentences.greeting.'. $intent);
    }

    public function getClosingMessage()
    {
        return $this->closing_text ?? config('bot.sentences.closing');
    }

    public function getStartedMessage()
    {
        $msg = !empty($this->greeting_text) ? $this->greeting_text : $this->getGreeting();
        $msg = str_replace('{{page}}', $this->page->name ?? '', $msg);

        return str_replace('|',"\n", $msg);
    }

    public function isAcceptedIntent($string)
    {
        return $this->selectableIntents->where('slug', $string)->isNotEmpty();
    }
}
