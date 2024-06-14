<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScreeningFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::exists('movies', 'title'),
            ],
            'theater_id' => [
                'required',
                'string',
                'max:255',
                Rule::exists('theaters', 'id'),
            ],
            'date' => 'required',
            'time' => 'required',
            'numDays' => 'nullable|integer|min:1|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'theater_id.required' => 'Theater is required',
            'title.exists' => 'Movie Title does not exist',
        ];
    }
}
