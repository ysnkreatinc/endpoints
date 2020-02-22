<?php

namespace Kreatinc\Bot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BotSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'presistent_menu'      => 'boolean',
            'home_valuation'       => 'boolean',
            'listings_suggestions' => 'boolean',
            'zipcode_text'         => 'string',
            'footage_unit'         => 'string',
            'ask_again'            => 'boolean',
            'whitelisted_domains'  => 'array',
            'logged_in'    => 'string',
            'logged_out'   => 'string',
        ];
    }
}
