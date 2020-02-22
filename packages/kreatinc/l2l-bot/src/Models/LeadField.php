<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Kreatinc\Bot\Libraries\Validation\EntityValidator;

class LeadField extends Model
{
    use SoftDeletes;

    protected $table = 'lead_fields';

    protected $fillable = [
        'type',
        'title',
        'entity_key',
        'entity_type',
        'position',
        'validation', // Our own validation for some fields
        'actions', // Actions to do after storing this field
        'is_hidden', // Hidden threaded question
        'store_raw_value', // Store raw value and not from wit
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'store_raw_value' => 'boolean',
    ];

    public function isValidEntity($entity, $text, $rawText)
    {
        $supportedEntities = array_merge(supported_entities_for($this->entity_key), supported_entities_for($this->entity_type));
        if (in_array($entity, $supportedEntities)) {
            return true;
        }
        if (! is_string($this->validation)) {
            return false;
        }
        return EntityValidator::make($this->validation, $text)->valid()
            || EntityValidator::make($this->validation, $rawText)->valid();
    }

    public function isVisible()
    {
        return $this->is_hidden === false;
    }

    public function acceptsRawValue()
    {
        return $this->store_raw_value;
    }

    public function hasActions()
    {
        return !empty($this->actions);
    }

    public function leadData()
    {
        return $this->hasMany(LeadData::class);
    }

    public function fieldChoices()
    {
        return $this->hasMany(FieldChoice::class);
    }

    public function intent()
    {
        return $this->belongsTo(Intent::class);
    }

    public function sentences()
    {
        return $this->hasMany(Sentence::class);
    }

    public function questions()
    {
        return $this->hasMany(Sentence::class)->where('sentence_type', 'question');
    }

    public function repliesAfter()
    {
        return $this->hasMany(Sentence::class)->where('sentence_type', 'reply_after');
    }

    public function errorLevelOne()
    {
        return $this->hasMany(Sentence::class)->where('sentence_type', 'error_level_1');
    }

    public function errorLevelTwo()
    {
        return $this->hasMany(Sentence::class)->where('sentence_type', 'error_level_2');
    }

    public function visibilityRules()
    {
        return $this->hasMany(Rule::class)->where('rule_type', 'visibility');
    }

    public function repliesRules()
    {
        return $this->hasMany(Rule::class)->where('rule_type', 'reply');
    }

    public function getQuestions()
    {
        $questions = $this->questions->random();

        return devide_msg($questions->text);
    }

    public function getRepliesAfter()
    {
        if ($this->repliesAfter->isNotEmpty()) {
            $reply_after = $this->repliesAfter->random();
            return devide_msg($reply_after->text);
        }

        return [];
    }

    public function getCatchErrorLevelOne()
    {
        if ($this->errorLevelOne->isNotEmpty()) {
            $reply = $this->errorLevelOne->random();
            $replies = $reply->text;
        } else {
            $replies = Arr::last($this->getQuestions());
        }
        $replies = config('bot.sentences.error_level_1') .'|'. $replies;

        return devide_msg($replies);
    }

    public function getCatchErrorLevelTwo($data)
    {
        if ($this->errorLevelTwo->isNotEmpty()) {
            $reply = $this->errorLevelTwo->random();
            return devide_msg($reply->text);
        }
        $reply = str_replace('{{data}}', $data, config('bot.sentences.error_level_2'));

        return devide_msg($reply);
    }
}
