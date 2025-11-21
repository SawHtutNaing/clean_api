<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'type' => ['required', Rule::in(['payment', 'refund', 'adjustment'])],
            'payment_method' => ['required_if:type,payment', Rule::in(['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'])],
            'payment_gateway' => ['nullable', 'string', 'max:100'],
            'gateway_transaction_id' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Order ID is required',
            'order_id.exists' => 'The selected order does not exist',
            'amount.required' => 'Transaction amount is required',
            'amount.min' => 'Transaction amount must be greater than 0',
            'type.required' => 'Transaction type is required',
            'type.in' => 'Invalid transaction type',
            'payment_method.required_if' => 'Payment method is required for payment transactions',
            'payment_method.in' => 'Invalid payment method',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->type === 'payment' && $this->amount) {
                $order = \App\Models\Order::find($this->order_id);

                if ($order) {
                    $totalPaid = $order->transactions()
                        ->completed()
                        ->sum('amount');

                    $remainingBalance = $order->total_amount - $totalPaid;

                    if ($this->amount > $remainingBalance) {
                        $validator->errors()->add(
                            'amount',
                            'Payment amount cannot exceed remaining balance of $'.number_format($remainingBalance, 2)
                        );
                    }
                }
            }

            if ($this->type === 'refund' && $this->amount) {
                $order = \App\Models\Order::find($this->order_id);

                if ($order) {
                    $totalPaid = $order->transactions()
                        ->completed()
                        ->payments()
                        ->sum('amount');

                    if ($this->amount > $totalPaid) {
                        $validator->errors()->add(
                            'amount',
                            'Refund amount cannot exceed total paid amount'
                        );
                    }
                }
            }
        });
    }
}
