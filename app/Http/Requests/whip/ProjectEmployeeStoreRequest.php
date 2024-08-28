<?php

namespace App\Http\Requests\whip;

use Illuminate\Foundation\Http\FormRequest;

class ProjectEmployeeStoreRequest extends FormRequest
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
                'project_monitoring_id'     => 'nullable',
                'project_id'     => 'nullable',
                'employee_id'               => 'required|string|min:1',
                'employee'                  => 'required|string|min:1',
                'employment_nature'         => 'required|string|min:1',
                'position'                  => 'required|string|min:1',
                'employment_status'         => 'required|string|min:1',
                'employment_level'          => 'required|string|min:1',
        ];
    }
}
