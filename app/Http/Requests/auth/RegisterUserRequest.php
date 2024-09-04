<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
                'first_name'        => 'required|string|min:1',
                'middle_name'       => 'nullable',
                'last_name'         => 'required|string|min:1',
                'extension'         => 'nullable',
                'contact_number'    => 'required|digits:11',
                'address'           => 'required',
                'office'            => 'required',
                'username'          => [
                    'required',
                    'min:6',
                    'regex:/[A-Z]/', 
                    'unique:users,username'
                ],
                'email_address'     => 'required|email|unique:users|max:255',
                'password' => [
                    'required',
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain at least Special Character
                    'required_with:confirm_password',
                    'same:confirm_password'
                ],
                'confirm_password'  => 'required|string|min:8',
        ];


    }

    public function messages()
    {
        return [
            'password.regex' => 'The :attribute must contain 1 Uppercase, Lowercas, Digit and Special Character minimum length is 8',
            'username.regex' => 'The :attribute must contain Uppercase',
        ];
    }
}
