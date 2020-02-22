<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    protected $table = 'sentences';

    protected $fillable = ['sentence_type','text','lead_field_id'];

    protected $valid_types = ['question', 'reply_after', 'error_level_1', 'error_level_2'];

    public function leadField()
    {
        return $this->belongsTo(LeadField::class);
    }

}