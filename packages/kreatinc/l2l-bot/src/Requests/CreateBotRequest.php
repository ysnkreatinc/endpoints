<?php

namespace Kreatinc\Bot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBotRequest extends FormRequest
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
            'greeting_text' => 'required|string|min:20',

            'page_id'      => 'required|string',
            'page_name'    => 'required|string',
            'page_token'   => 'required|string|min:20',

            'l2l_token'        => 'required|string',
            'l2l_member_id'    => 'required|integer',
            'facebook_user_id' => 'required|string',
        ];
    }
}
