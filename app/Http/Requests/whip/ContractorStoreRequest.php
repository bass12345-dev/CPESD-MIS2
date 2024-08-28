<?php

namespace App\Http\Requests\whip;

use Illuminate\Foundation\Http\FormRequest;

class ContractorStoreRequest extends FormRequest
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
    public function rules(): array
    {
        $default_connection = config('custom_config.database.lls_whip');
        return [
                'contractor_name'       => 'required|string|min:3',
                'proprietor'            => 'required|string|min:3',
                'street'                => 'nullable',
                'barangay'              => 'nullable|string|min:3',
                'barangay_code'         => 'nullable|string|min:3',
                'city'                  => 'required|string|min:3',
                'city_code'             => 'nullable|string|min:3',
                'province'              => 'required|string|min:3',
                'province_code'         => 'nullable|string|min:3',
                'phone_number'          => 'nullable|digits:11',
                'phone_number_owner'    => 'nullable|string|min:3',
                'telephone_number'      => 'nullable',
                'email_address'         => 'nullable|email|unique:'.$default_connection.'.establishments|max:255',   

        ];
    }
}
