<?php

namespace Kreatinc\Bot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBotIntentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label'     => 'string|max:25',
            'in_menu'   => 'boolean',
        ];
    }
}
