<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
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

    ];
}


    public function messages(): array
    {
        return [];
    }
}
