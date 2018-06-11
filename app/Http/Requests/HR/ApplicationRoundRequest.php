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
            'refer_to' => 'nullable|string|required_if:action,refer',
            'scheduled_date' => 'nullable|date|required_if:action,schedule-update',
            'scheduled_person_id' => 'nullable|integer|required_if:action,schedule-update',
            'next_round' => 'nullable|string|required_if:action,confirm',
            'create_calendar_event' => 'nullable|filled',
            'summary_calendar_event' => 'nullable|string|required_with:create_calendar_event',
            'next_scheduled_start' => 'nullable|date|required_if:action,confirm',
            'next_scheduled_end' => 'nullable|date|required_with:create_calendar_event',
            'next_scheduled_person_id' => 'nullable|integer|required_if:action,confirm',
            'round_evaluation' => 'nullable|array',
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
            'next_scheduled_start.required_if' => 'The schedule date for next round is required.',
            'next_scheduled_end.required_with' => 'The end time for the interview is required',
            'next_scheduled_person_id.required_if' => 'The interviewer for next round is required.',
        ];
    }
}
