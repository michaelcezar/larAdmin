<?php

namespace App\Http\Requests\password;

use Illuminate\Foundation\Http\FormRequest;
use App\ExtraClass\appMessages;

class resetPasswordRequest extends FormRequest
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
            'email'           => 'required|email|max:255',
            'token'           => 'required|min:50',
            'password'        => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:password',
        ];
    }

    public function messages(){
        return appMessages::returnRequestMessage();
    }

}