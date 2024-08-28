<?php

namespace App\Http\Requests\lls;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $default_connection = config('custom_config.database.lls_whip');
        return [ 
                'first_name'                => 'required|string|min:1', 
                'middle_name'               => 'nullable',   
                'last_name'                 => 'required|string|min:1', 
                'extension'                 => 'nullable',   
                'province'                  => 'required|string|min:1', 
                'city'                      => 'required|string|min:1', 
                'barangay'                  => 'nullable',   
                'street'                    => 'nullable',   
                'gender'                    => 'required|string|min:1', 
                'contact_number'            => 'nullable|digits:11',
                'birthdate'                 => 'nullable',   
        ];
    }
}
