<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class Intent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',     // Key connected to Wit.ai
        'lead_legend',
        'selectable',   // Can be selected as part of the supported visible intents
        'add_to_menu',  // can add it to Messenger menu
        'label',    // Short text for quick replies
        'replies_after', // Reply after the intent is chosen
    ];

    /**
     * We will load the intents slugs and store them in this attribute
     * so we can use it instead of querying the database everytime
     *
     * @var array
     */
    protected static $valid_intents = [];

    /**
     * @param string $string
     * @return bool
     */
    public static function isValidIntent($string)
    {
        if (empty(self::$valid_intents)) {
            self::$valid_intents = self::pluck('slug')->all();
        }
        return in_array($string, self::$valid_intents);
    }

    /**
     * Columns of the pivot bot_intents
     * @return array
     */
    public static function pivotFields()
    {
        return [
            'label',
            'in_menu'
        ];
    }

    /**
     * Bot Type Bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scopeSelectable($query)
    {
        return $query->where('selectable', true);
    }

    public function bots()
    {
        return $this->belongsToMany(Bot::class, 'bot_intents')->withPivot(self::pivotFields());
    }

    public function fields()
    {
        return $this->hasMany(LeadField::class);
    }

    public function getLabel()
    {
        // pivot value is intered by users, so it overwrites the default one
        return $this->pivot->label ?? $this->label;
    }

    public function getWitValue()
    {
        return $this->slug;
    }

    public function isListing()
    {
        return $this->slug === 'listing';
    }

    public function getReplyAfter()
    {
        if (!empty($this->replies_after)) {
            return devide_msg($this->replies_after);
        }

        return [];
    }
}
