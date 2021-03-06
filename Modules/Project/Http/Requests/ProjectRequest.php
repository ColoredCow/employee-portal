<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => 'required|string',
            'client_id' => 'required|integer',
            'status' => 'sometimes|string',
            'project_manager' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_project_id.required' => 'Project ID is required',
            'client_project_id.integer' => 'Project ID should be a valid number',
            'invoice_email.email' => 'Email for invoice should a valid email address',
        ];
    }
}
