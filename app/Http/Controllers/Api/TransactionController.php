<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['order', 'user']);

        // Filtering by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtering by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtering by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filtering by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtering by order
        if ($request->has('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Date range filtering
        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        // Amount range filtering
        if ($request->has('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->has('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        // Search by transaction number
        if ($request->has('search')) {
            $query->where('transaction_number', 'like', '%'.$request->search.'%');
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->input('per_page', 15);
        $transactions = $query->paginate($perPage);

        return TransactionResource::collection($transactions);
    }

    /**
     * Store a newly created transaction
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($request->order_id);

            // Create transaction
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'user_id' => $request->user_id ?? auth()->id(),
                'amount' => $request->amount,
                'type' => $request->type,
                'payment_method' => $request->payment_method,
                'payment_gateway' => $request->payment_gateway,
                'gateway_transaction_id' => $request->gateway_transaction_id,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            DB::commit();

            return new TransactionResource($transaction->load(['order', 'user']));

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction->load(['order', 'user']));
    }

    /**
     * Update the specified transaction
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        // Prevent updating completed/refunded transactions
        if (in_array($transaction->status, ['completed', 'refunded'])) {
            return response()->json([
                'error' => 'Cannot update transaction',
                'message' => 'Completed or refunded transactions cannot be modified',
            ], 422);
        }

        $transaction->update($request->validated());

        // Update timestamps based on status
        if ($request->status === 'completed' && ! $transaction->processed_at) {
            $transaction->update(['processed_at' => now()]);
        }

        if ($request->status === 'failed' && ! $transaction->failed_at) {
            $transaction->update(['failed_at' => now()]);
        }

        if ($request->status === 'refunded' && ! $transaction->refunded_at) {
            $transaction->update(['refunded_at' => now()]);
        }

        return new TransactionResource($transaction->load(['order', 'user']));
    }

    /**
     * Process a pending transaction
     */
    public function process(ProcessTransactionRequest $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return response()->json([
                'error' => 'Invalid transaction status',
                'message' => 'Only pending transactions can be processed',
            ], 422);
        }

        try {
            DB::beginTransaction();

            $transaction->update([
                'status' => 'completed',
                'gateway_transaction_id' => $request->gateway_transaction_id,
                'gateway_response' => $request->gateway_response,
                'processed_at' => now(),
            ]);

            // Update order status if fully paid
            $order = $transaction->order;
            $totalPaid = $order->transactions()->completed()->sum('amount');

            if ($totalPaid >= $order->total_amount) {
                $order->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            DB::commit();

            return new TransactionResource($transaction->load(['order', 'user']));

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Mark transaction as failed
     */
    public function fail(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return response()->json([
                'error' => 'Invalid transaction status',
                'message' => 'Only pending transactions can be marked as failed',
            ], 422);
        }

        $transaction->update([
            'status' => 'failed',
            'gateway_response' => $request->input('reason', 'Payment failed'),
            'failed_at' => now(),
        ]);

        return new TransactionResource($transaction->load(['order', 'user']));
    }

    /**
     * Refund a completed transaction
     */
    public function refund(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'completed' || $transaction->type !== 'payment') {
            return response()->json([
                'error' => 'Cannot refund transaction',
                'message' => 'Only completed payment transactions can be refunded',
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create refund transaction
            $refund = Transaction::create([
                'order_id' => $transaction->order_id,
                'user_id' => $transaction->user_id,
                'amount' => $request->input('amount', $transaction->amount),
                'type' => 'refund',
                'payment_method' => $transaction->payment_method,
                'payment_gateway' => $transaction->payment_gateway,
                'notes' => $request->input('notes', 'Refund for transaction '.$transaction->transaction_number),
                'status' => 'completed',
                'processed_at' => now(),
                'refunded_at' => now(),
            ]);

            // Mark original transaction as refunded
            $transaction->update([
                'status' => 'refunded',
                'refunded_at' => now(),
            ]);

            DB::commit();

            return new TransactionResource($refund->load(['order', 'user']));

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified transaction
     */
    public function destroy(Transaction $transaction)
    {
        // Only allow deletion of pending or failed transactions
        if (! in_array($transaction->status, ['pending', 'failed', 'cancelled'])) {
            return response()->json([
                'error' => 'Cannot delete transaction',
                'message' => 'Only pending, failed, or cancelled transactions can be deleted',
            ], 422);
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully',
        ], 200);
    }

    /**
     * Get transaction statistics
     */
    public function stats(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30));
        $endDate = $request->input('end_date', now());

        $stats = [
            'total_transactions' => Transaction::dateRange($startDate, $endDate)->count(),
            'total_amount' => Transaction::completed()->dateRange($startDate, $endDate)->sum('amount'),
            'total_payments' => Transaction::payments()->completed()->dateRange($startDate, $endDate)->sum('amount'),
            'total_refunds' => Transaction::refunds()->dateRange($startDate, $endDate)->sum('amount'),
            'by_status' => Transaction::dateRange($startDate, $endDate)
                ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->groupBy('status')
                ->get(),
            'by_payment_method' => Transaction::payments()->completed()->dateRange($startDate, $endDate)
                ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->groupBy('payment_method')
                ->get(),
            'success_rate' => $this->calculateSuccessRate($startDate, $endDate),
        ];

        return response()->json($stats);
    }

    private function calculateSuccessRate($startDate, $endDate)
    {
        $total = Transaction::payments()->dateRange($startDate, $endDate)->count();
        $completed = Transaction::payments()->completed()->dateRange($startDate, $endDate)->count();

        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }
}
