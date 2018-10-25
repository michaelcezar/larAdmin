<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use App\ExtraClass\appMessages;

class userRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:60',
            'email'    => 'required|max:255|email|unique:users',
            'password' => 'required|min:6',
            'type'     => 'required|numeric',
            'status'   => 'required|numeric'
        ];
    }

    public function messages(){
        return appMessages::returnRequestMessage();
    }

}
