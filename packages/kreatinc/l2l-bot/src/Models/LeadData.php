<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;

class LeadData extends Model
{
    protected $table = 'lead_data';

    protected $fillable = ['value','message_id','key','lead_field_id','conversation_id'];

    public function leadField()
    {
        return $this->belongsTo(LeadField::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}