<?php

namespace App\Http\Requests\login;

use Illuminate\Foundation\Http\FormRequest;
use App\ExtraClass\appMessages;

class loginRequest extends FormRequest
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
            'email'    => 'required|max:255',
            'password' => 'required|min:6'
        ];
    }

    public function messages(){
        return appMessages::returnRequestMessage();
    }
}
