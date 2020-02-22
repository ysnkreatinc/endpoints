<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class FieldChoice extends Model
{
    protected $table = 'field_choices';

    protected $fillable = ['type','text','payload','lead_field_id'];

    protected $valid_types = ['text','phone','email','location'];

    public function leadField()
    {
        return $this->belongsTo(LeadField::class);
    }

}