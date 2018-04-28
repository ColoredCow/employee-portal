<?php

namespace App\Http\Requests\KnowledgeCafe\Library;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'add_method' => 'filled|string',
            'title' => 'filled|string',
            'author' => 'filled|string',
            'readable_link' => 'filled|string',
            'categories' => 'filled|string',
            'thumbnail' => 'filled|string',
            'isbn' => 'filled|string'
        ];
    }

}
