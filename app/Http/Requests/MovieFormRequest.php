<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
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
            'title' =>         'required|string|max:255', 
            'genre_code' =>    'required|exists:genres,code', 
            'year' =>            'required|digits:4', 
            'synopsis' =>        'required|string',
            'poster_filename' => 'nullable|image|mimes:jpg,jpeg,png',
            'trailer_url' => 'nullable|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'genre_code.required' => 'Genre is required',
            'year.required' => 'Year is required',
            'synopsis.required' => 'Synopsis is required',
        ];
    }
}
