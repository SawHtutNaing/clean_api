<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_number' => $this->transaction_number,
            'order' => [
                'id' => $this->order_id,
                'order_number' => $this->whenLoaded('order', fn () => $this->order->order_number),
                'total_amount' => $this->whenLoaded('order', fn () => $this->order->total_amount),
            ],
            'user' => [
                'id' => $this->user_id,
                'name' => $this->whenLoaded('user', fn () => $this->user->name),
                'email' => $this->whenLoaded('user', fn () => $this->user->email),
            ],
            'amount' => $this->amount,
            'formatted_amount' => '$'.number_format($this->amount, 2),
            'type' => $this->type,
            'type_label' => ucfirst($this->type),
            'payment_method' => $this->payment_method,
            'payment_method_label' => $this->payment_method ? str_replace('_', ' ', ucwords($this->payment_method, '_')) : null,
            'status' => $this->status,
            'status_label' => ucfirst($this->status),
            'payment_gateway' => $this->payment_gateway,
            'gateway_transaction_id' => $this->gateway_transaction_id,
            'notes' => $this->notes,
            'processed_at' => $this->processed_at?->toIso8601String(),
            'failed_at' => $this->failed_at?->toIso8601String(),
            'refunded_at' => $this->refunded_at?->toIso8601String(),
d
        ];
    }
}
