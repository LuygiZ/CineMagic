<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterFormRequest extends FormRequest
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
    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'rows' => 'required|integer|min:1|max:25',
        'seats_per_row' => 'required|integer|min:1',
        'photo_filename' => 'nullable|image|max:2048',
    ];
}


    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'photo_filename.required' => 'Photo is required',
        ];
    }
}
