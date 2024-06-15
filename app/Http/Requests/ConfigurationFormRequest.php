<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationFormRequest extends FormRequest
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
        'ticketPrice' => 'required|numeric|min:0|max:100',
        'newCustomerDiscount' => 'required|numeric|min:0|lte:ticketPrice'
    ];
}


    public function messages(): array
    {
        return [
            'newCustomerDiscount.lte' => 'The new customer discount cannot be greater than the ticket price.',
        ];
    }
}
