<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gateway_transaction_id' => ['required', 'string', 'max:255'],
            'gateway_response' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'gateway_transaction_id.required' => 'Gateway transaction ID is required to process payment',
        ];
    }
}
