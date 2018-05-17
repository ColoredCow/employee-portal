<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRoundRequest extends FormRequest
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
            'reviews' => 'nullable',
            'action' => 'required|string',
            'next_round' => 'nullable|string|required_if:action,confirm',
            'refer_to' => 'nullable|string|required_if:action,refer'
        ];
    }
}
