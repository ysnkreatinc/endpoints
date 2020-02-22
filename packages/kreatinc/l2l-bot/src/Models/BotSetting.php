<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class BotSetting extends Model
{
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'presistent_menu',
        'home_valuation',
        'listings_suggestions',
        'zipcode_text',
        'footage_unit',
        'ask_again',
        'whitelisted_domains',
        'logged_in',
        'logged_out',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'presistent_menu'      => 'boolean',
        'home_valuation'       => 'boolean',
        'listings_suggestions' => 'boolean',
        'ask_again'            => 'boolean',
        'whitelisted_domains'  => 'array',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'bot_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function updateData(array $data)
    {
        $this->fill($data);
        $this->save();

        return $this;
    }
}
