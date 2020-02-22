<?php

namespace Kreatinc\Bot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBotRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string',
            'listing_id'    => 'integer',
            'closing_text'  => 'string',
            'intro_text'    => 'string',
            'greeting_text' => 'string|min:20',

            'page_id'      => 'string',
            'page_name'    => 'string',
            'page_token'   => 'string|min:20',

            'l2l_token'        => 'string',
            'l2l_member_id'    => 'integer',
            'facebook_user_id' => 'string',
        ];
    }
}
