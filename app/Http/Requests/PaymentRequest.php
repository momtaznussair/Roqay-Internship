<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
        $avalable_methods = config('myfatoorah.available_payment_methods')->pluck('PaymentMethodId');

        return [
            'paymentMethodId' => [
                Rule::requiredIf(env('PAYMENT_SERVICE') == 'myfatoora'),
                Rule::in($avalable_methods)
            ]
        ];
    }
}
