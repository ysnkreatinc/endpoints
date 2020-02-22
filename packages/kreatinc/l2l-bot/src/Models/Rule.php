<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rules';

    protected $fillable = [
        'rule_type',
        'target', // entity_key
        'validation_rules',
        'success_reply',
        'fail_reply',
    ];

    protected $valid_types = [
        'visibility',
        'reply'
    ];

    public function leadField()
    {
        return $this->belongsTo(LeadField::class);
    }
}