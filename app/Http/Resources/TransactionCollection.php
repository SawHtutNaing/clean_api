<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
            ],
            'summary' => [
                'total_transactions' => $this->total(),
                'total_amount' => $this->sum('amount'),
                'completed_count' => $this->where('status', 'completed')->count(),
                'pending_count' => $this->where('status', 'pending')->count(),
                'failed_count' => $this->where('status', 'failed')->count(),
            ],
        ];
    }
}
