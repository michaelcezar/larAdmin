<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use App\ExtraClass\appMessages;

class updatePasswordRequest extends FormRequest
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
            'id'                 => 'required|numeric',
            'newPassword'        => 'required|min:6',
            'confirmNewPassword' => 'required|min:6|same:newPassword',
        ];
    }

     public function messages(){
        return appMessages::returnRequestMessage();
    }
}
