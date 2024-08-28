<?php

namespace App\Http\Requests\lls;

use Illuminate\Foundation\Http\FormRequest;

class SurveyStoreRequest extends FormRequest
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
        $default_connection = config('app._database.lls_whip');
        return [
                'establishment_id'          => 'nullable',
                'year'                      => 'nullable',
                'inside_permanent'          => 'required|digits_between:0,999999999999',
                'inside_probationary'       => 'required|digits_between:0,999999999999',
                'inside_contractuals'       => 'required|digits_between:0,999999999999',
                'inside_project_based'      => 'required|digits_between:0,999999999999',
                'inside_seasonal'           => 'required|digits_between:0,999999999999',
                'inside_job_order'          => 'required|digits_between:0,999999999999',
                'inside_mgt'                => 'required|digits_between:0,999999999999',

                'outside_permanent'          => 'required|digits_between:0,999999999999',
                'outside_probationary'       => 'required|digits_between:0,999999999999',
                'outside_contractuals'       => 'required|digits_between:0,999999999999',
                'outside_project_based'      => 'required|digits_between:0,999999999999',
                'outside_seasonal'           => 'required|digits_between:0,999999999999',
                'outside_job_order'          => 'required|digits_between:0,999999999999',
                'outside_mgt'                => 'required|digits_between:0,999999999999',
               
                
        ];
    }
}
