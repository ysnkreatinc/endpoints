<?php

namespace Kreatinc\Bot\Libraries\Validation;

use Illuminate\Support\Str;

class EntityValidator
{
    protected $available_rules = [
        'address',
        'city',
        'any_text',
        'street',
        'zipcode',
        'contact_me',
        'agreed',
        'callme',
        'emailme',
        'empty',
        'refuse',
        'not_email',
    ];

	public $text;

	/**
	 * The validation rules.
	 *
	 * @var array
	 */
	protected $rules = [];

	/**
	 * Create a new instance.
	 *
	 * @param  string  $rules
	 * @param  string  $text
	 * @return void
	 */
	public function __construct(string $rules, $text)
	{
		$this->rules = explode('|', $rules);
		$this->text = empty($text) ? '' : $text;
	}

	/**
	 * @param  string  $rules
	 * @param  string  $text
	 * @return EntityValidator
	 */
	public static function make($rules, $text)
	{
		return new static($rules, $text);
	}

	/**
	 * @return bool
	 */
	public function valid()
	{
		foreach ($this->rules as $rule) {
			if ($this->check($this->text, $rule)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param  string  $text
	 * @param  string  $rule
	 * @return bool
	 */
	protected function check($text, $rule)
	{
		if (!in_array($rule, $this->available_rules)) {
			return false;
		}
		return $this->{Str::camel('validate_'. $rule)}($text);
	}

	protected function validateAddress($text)
	{
		return Str::length($text) > 7 && preg_match('/[a-z]{3}/i', $text);
	}

	protected function validateCity($text)
	{
		return preg_match('/[a-z]{3}/i', $text);
	}

	protected function validateAnyText($text)
	{
		return preg_match('/[a-z]{2}/i', $text);
	}

	protected function validateStreet($text)
	{
		return preg_match('/[a-z]{4}/i', $text);
		# return preg_match('/^(\d{3,})\s?(\w{0,5})\s([a-zA-Z]{2,30})\s([a-zA-Z]{2,15})\.?\s?(\w{0,5})$/', $text);
	}

	protected function validateZipcode($text)
	{
		return preg_match('/\d+/i', $text);
	}

	protected function validateContactMe($text)
	{
		return $this->containsAny($text, ['call', 'email', 'yes', 'sure']);
	}

	protected function validateAgreed($text)
	{
		return $this->containsAny($text, ['yes']);
	}

	protected function validateRefuse($text)
	{
		return $this->containsAny($text, ['no', 'sorry']);
	}

	protected function validateCallme($text)
	{
		return $this->containsAny($text, ['call', 'phone']);
	}

	protected function validateEmailme($text)
	{
		return $this->containsAny($text, ['mail']);
	}

	protected function validateEmpty($text)
	{
		return empty($text);
	}

	protected function validateNotEmail($text)
	{
		return ! filter_var($text, FILTER_VALIDATE_EMAIL);
	}

    public static function containsAny($text, array $expressions)
    {
        foreach ($expressions as $expression) {
        	$expression = '/'.$expression.'/i';
            if (preg_match($expression, $text) === 1) {
                return true;
            }
        }
        return false;
    }
}
