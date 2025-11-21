<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            'discount_amount' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
