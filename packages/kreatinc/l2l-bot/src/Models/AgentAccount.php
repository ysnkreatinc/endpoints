<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'facebook_user_id',
    	'facebook_first_name',
    	'facebook_last_name',
        'access_token',
        'agent_id',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'facebook_user_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Token agent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
	    return $this->belongsTo(Agent::class);
    }
}
