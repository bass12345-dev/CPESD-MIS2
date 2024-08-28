<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablishmentStoreRequest extends FormRequest
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
                'establishment_code'    => 'required|digits between:3,200|unique:'.$default_connection.'.establishments',
                'establishment_name'    => 'required|string|min:1',
                'authorized_personnel'  => 'required|string|min:1',
                'position'              => 'required|string|min:1',
                'street'                => 'nullable',
                'barangay'              => 'nullable',
                'contact_number'        => 'required|digits:11',
                'telephone_number'        => 'nullable',
                'email_address'         => 'nullable|email|unique:'.$default_connection.'.establishments|max:255',   
        ];
    }
}
