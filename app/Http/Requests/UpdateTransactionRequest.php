<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::in(['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])],
            'payment_gateway' => ['sometimes', 'string', 'max:100'],
            'gateway_transaction_id' => ['sometimes', 'string', 'max:255'],
            'gateway_response' => ['sometimes', 'string'],
            'notes' => ['sometimes', 'string', 'max:1000'],
        ];
    }
}
