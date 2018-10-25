<?php

namespace App\Http\Requests\admin;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\ExtraClass\appMessages;

class updateUserRequest extends FormRequest
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
        $user=new User();
        $user->id=$this->input('id');
        return [
            'id'       => 'required|numeric',
            'name'     => 'required|max:60',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'type'     => 'required|numeric',
            'status'   => 'required|numeric'
        ];
    }

    public function messages(){
        return appMessages::returnRequestMessage();
    }
}
