<?php

namespace Kreatinc\Bot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Kreatinc\Bot\Exceptions\SilentException;
use Kreatinc\Bot\Libraries\Validation\EntityValidator;

class Conversation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'lead_client_id',
        'lead_id',
        'intent_id',
        'type',
        'step',
        'next',
        'verify_counter',
        'closed_at',
        'paused_at',
        'completed'
    ];

    /**
     * Store the current message of this conversation
     *
     * @var \Kreatinc\Bot\Models\Message
     */
    public $currentMessage;

    /**
     * Find The User by his social account ID
     */
    public static function findCurrentByCustomer($page_id, $customer_id)
    {
        $conversation = static::where('lead_client_id', $customer_id)
                              ->where('page_id', $page_id)
                              ->whereNull('closed_at')
                              ->where('completed', '=', 0)
                              ->orderBy('id', 'desc')
                              ->first();

        if (is_null($conversation)) {
            $conversation = static::create([
                'lead_client_id' => $customer_id,
                'page_id' => $page_id,
            ]);
        }

        return $conversation;
    }

    public function cloneToNew()
    {
        $this->close();

        $conversation = static::create([
            'lead_client_id' => $this->customer_id,
            'page_id' => $this->page_id,
        ]);

        return $conversation;
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->step = 'type';
        $this->next = null;
        $this->intent_id = Intent::where('slug', $type)->first()->id;

        $this->save();

        return $this;
    }

    public function hasValidType()
    {
        // TODO use intent_id
        return Intent::isValidIntent($this->type);
    }

    public function setNextStep($step, $next = null)
    {
        $this->step = $step;
        $this->next = $next;
        $this->save();

        return $this;
    }

    /**
     * Set the current message for the conversation.
     * This will be the database representation of the response message.
     *
     * @param \Kreatinc\Bot\Contracts\Incoming $message
     * @return \Kreatinc\Bot\Models\Message
     */
    public function setCurrentMessage($message)
    {
        // If the message already exists throw exception and stop the Bot.
        try {
            $this->currentMessage = Message::createFromData(
                $message->getMessageID(),
                $message->getSender(),
                $this->page->account_id === $message->getSender(),
                $this->id,
                $message->getMainContent() ?? '-',
                $message->getType(),
                $message->getTimestamp()
            );
        } catch (\Exception $e) {
            throw new SilentException($e->getMessage());
        }

        return $this->currentMessage;
    }

    public function nextRemainingField()
    {
        $fieldsIDs = $this->leadData()->get('lead_field_id')->pluck('lead_field_id')->all();
        $fieldsIDs = array_filter($fieldsIDs);

        while (true) {
            $nextField = LeadField::where('intent_id', $this->intent_id)
                    ->whereNotIn('id', $fieldsIDs)
                    ->orderBy('position')
                    ->first();

            if (is_null($nextField) || $nextField->isVisible()) {
                break;
            }
            if ($rule = $nextField->visibilityRules->first()) {
                $value = $this->getDataByKey($rule->target);
                if (EntityValidator::make($rule->validation_rules, $value)->valid()) {
                    break;
                }
            }
            $fieldsIDs[] = $nextField->id;
            $this->addLeadData($nextField->entity_key, '');
        }

        return $nextField;
    }

    /**
     * Current conversation field.
     *
     * @return \Kreatinc\Bot\Models\LeadField
     */
    public function currentField()
    {
        return LeadField::where([
            'entity_key'  => $this->step,
            'intent_id' => $this->intent_id,
        ])->first();
    }

    /**
     * Get the field from entity key.
     *
     * @param  string $key
     * @return \Kreatinc\Bot\Models\LeadField
     */
    public function field(string $key)
    {
        // Validate if the $key not empty, since it's an require field.
        if (empty($key)) {
            throw new SilentException('You need to provide the field key');
        }

        return LeadField::where([
            'entity_key'  => $key,
            'intent_id' => $this->intent_id,
        ])->first();
    }

    /**
     * Get the field data for the current conversation.
     *
     * @param  string $key
     * @return \Kreatinc\Bot\Models\LeadData
     */
    public function fieldData(string $key)
    {
        // Validate if the $key not empty, since it's an require field.
        if (empty($key)) {
            throw new SilentException('You need to provide the field key');
        }

        $field = $this->field($key);

        $data = LeadData::where([
            'conversation_id' => $this->id,
            'lead_field_id'   => $field->id,
        ])->first();

        return $data->value ?? '';
    }

    public function getDataByKey(string $key)
    {
        $data = LeadData::where([
            'conversation_id' => $this->id,
            'key'   => $key,
        ])->first();

        return $data->value ?? '';
    }

    /**
     * Store the conversation field data.
     *
     * @param  string  $field_type
     * @param  string  $value
     * @return \Kreatinc\Bot\Models\LeadField
     */
    public function addLeadData($field_type, $value)
    {
        $leadField = LeadField::where('entity_key', '=', $field_type)
                            ->where('intent_id', $this->intent_id)
                            ->firstOrFail();

        $leadData = $this->leadData()->create([
                'lead_field_id' => $leadField->id,
                'key' => $leadField->entity_key,
                'value' => $value,
                'message_id' => $this->currentMessage->id,
            ]);

        return $leadData;
    }

    /**
     * Store the conversation field data by key.
     * Used for actions
     */
    public function storeLeadDataByKey($key, $value)
    {
        $leadData = $this->leadData()->create([
                'key' => $key,
                'value' => $value,
                'message_id' => $this->currentMessage->id,
            ]);

        return $leadData;
    }

    public function isPaused()
    {
        return $this->paused_at && Date::parse($this->paused_at) > Date::yesterday();
    }

    /**
     * Checks if the conversation is paused before an hour from now.
     *
     * @return bool
     */
    public function isPausedOneDay()
    {
        return $this->paused_at && Date::parse($this->paused_at)->addDay() > Date::now();
    }

    public function stopConversation()
    {
        $this->paused_at = now();
        $this->save();
    }

    public function close()
    {
        $this->closed_at = now();
        $this->save();
    }

    public function complete()
    {
        $this->completed = true;
        $this->save();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function leadData()
    {
        return $this->hasMany(LeadData::class);
    }

    public function leadClient()
    {
        return $this->belongsTo(LeadClient::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function intent()
    {
        return $this->belongsTo(Intent::class);
    }
}
