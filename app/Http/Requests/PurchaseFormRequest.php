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
            'customer_email' => 'required|max:255|email',
            'nif' => 'required|regex:/^[0-9]{9}$/',
            'total_price' => 'required|numeric',
            'payment_type' => 'required|in:VISA,MBWAY,PAYPAL',
            'visa_ref' => 'nullable|required_if:payment_type,VISA|regex:/^[0-9]{16}$/',
            'cvc_ref' => 'nullable|required_if:payment_type,VISA|regex:/^[0-9]{3}$/',
            'mbway_ref' => 'nullable|required_if:payment_type,MBWAY|regex:/^[0-9]{9}$/',
            'paypal_ref' => 'nullable|required_if:payment_type,PAYPAL|email',
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
            'customer_email.max' => 'Email may not be greater than 255 characters',
            'customer_email.email' => 'Email must be a valid email',
            'nif.required' => 'NIF is required',
            'nif.regex' => 'The NIF must be exactly 9 numeric digits',
            'payment_type.required' => 'Payment type is required',
            'payment_type.in' => 'That payment type is not allowed',
            'visa_ref.required_if' => 'Visa Card is required',
            'visa_ref.regex' => 'The Visa card number must be exactly 16 numeric digits',
            'cvc_ref.required_if' => 'CVC is required',
            'cvc_ref.regex' => 'The CVC must be exactly 3 numeric digits',
            'mbway_ref.required_if' => 'MBWay phone number is required',
            'mbway_ref.regex' => 'The MBWay phone must be exactly 9 numeric digits',
            'paypal_ref.required_if' => 'PayPal email is required',
            'paypal_ref.email' => 'The PayPal email must be a valid email address',
        ];
    }
}
