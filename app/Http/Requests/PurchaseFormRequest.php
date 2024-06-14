<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|max:255|email',
            'nif' => 'required|regex:/^[0-9]{9}$/',
            'total_price' => 'required|numeric',
            'payment_type' => 'required',
            'payment_ref' => 'required|string',
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Name is required',
            'customer_name.string' => 'Name must be a string',
            'customer_name.max' => 'Name may not be greater than 255 characters',
            'customer_email.required' => 'Email is required',
            'customer_email.string' => 'Email must be a string',
            'customer_email.max' => 'Email may not be greater than 255 characters',
            'customer_email.email' => 'Email must be a valid email',
            'nif.required' => 'NIF is required',
            'nif.regex' => 'The NIF must be exactly 9 numeric digits',
        ];
    }
}
