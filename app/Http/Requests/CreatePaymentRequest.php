<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware handles auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'payment_channel' => 'nullable|string|in:virtual_account,qris,credit_card',
            // API Key and Signature are in headers, handled by Middleware
        ];
    }
}
