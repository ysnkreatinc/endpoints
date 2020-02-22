<?php

namespace Kreatinc\Bot\Libraries;

use Kreatinc\Bot\Libraries\Validation\EntityValidator;
use Kreatinc\Bot\Models\Rule;

class ApplyRules
{
    protected $conversation;
    protected $replies = [];
    protected $rules;

    public function __construct($conversation, $rules)
    {
        $this->conversation = $conversation;
        $this->rules = $rules;
    }

    public static function make($conversation, $rules)
    {
        return new static($conversation, $rules);
    }

    public function applyAll()
    {
        foreach ($this->rules as $rule) {
            $rule_reply = $this->apply($rule);
            $this->replies = array_merge($this->replies, $rule_reply);
        }
    }

    protected function apply(Rule $rule)
    {
        $value = $this->conversation->getDataByKey($rule->target);
        if (EntityValidator::make($rule->validation_rules, $value)->valid()) {
            return devide_msg($rule->success_reply);
        }
        return devide_msg($rule->fail_reply);
    }

    public function rulesReplies()
    {
        return $this->replies;
    }
}
