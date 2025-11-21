<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

/**
 * Transaction Service with Common Patterns
 */
class TransactionService
{
    /**
     * Example 1: Complete payment flow for an order
     */
    public function processOrderPayment(Order $order, array $paymentData)
    {
        DB::beginTransaction();

        try {
            // Create pending transaction
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'amount' => $paymentData['amount'],
                'type' => 'payment',
                'payment_method' => $paymentData['payment_method'],
                'payment_gateway' => $paymentData['gateway'] ?? null,
                'status' => 'pending',
            ]);

            // Simulate payment gateway call
            $gatewayResponse = $this->processWithGateway($transaction, $paymentData);

            if ($gatewayResponse['success']) {
                // Mark transaction as completed
                $transaction->update([
                    'status' => 'completed',
                    'gateway_transaction_id' => $gatewayResponse['transaction_id'],
                    'gateway_response' => json_encode($gatewayResponse),
                    'processed_at' => now(),
                ]);

                // Check if order is fully paid
                $this->checkOrderPaymentStatus($order);
            } else {
                // Mark transaction as failed
                $transaction->update([
                    'status' => 'failed',
                    'gateway_response' => json_encode($gatewayResponse),
                    'failed_at' => now(),
                ]);
            }

            DB::commit();

            return $transaction;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Example 2: Process partial payment
     */
    public function processPartialPayment(Order $order, $amount, $paymentMethod)
    {
        $remainingBalance = $order->total_amount - $order->total_paid;

        if ($amount > $remainingBalance) {
            throw new \Exception("Payment amount exceeds remaining balance of $remainingBalance");
        }

        return $this->processOrderPayment($order, [
            'amount' => $amount,
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * Example 3: Process full refund
     */
    public function processFullRefund(Transaction $transaction, $reason = null)
    {
        if ($transaction->type !== 'payment' || $transaction->status !== 'completed') {
            throw new \Exception('Only completed payment transactions can be refunded');
        }

        DB::beginTransaction();

        try {
            // Create refund transaction
            $refund = Transaction::create([
                'order_id' => $transaction->order_id,
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                'type' => 'refund',
                'payment_method' => $transaction->payment_method,
                'payment_gateway' => $transaction->payment_gateway,
                'notes' => $reason ?? "Full refund for {$transaction->transaction_number}",
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

            return $refund;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Example 4: Check order payment status and update
     */
    private function checkOrderPaymentStatus(Order $order)
    {
        $totalPaid = $order->transactions()
            ->completed()
            ->payments()
            ->sum('amount');

        if ($totalPaid >= $order->total_amount) {
            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        } elseif ($totalPaid > 0) {
            $order->update([
                'status' => 'processing',
            ]);
        }
    }

    /**
     * Example 5: Get payment summary for an order
     */
    public function getOrderPaymentSummary(Order $order)
    {
        return [
            'order_total' => $order->total_amount,
            'total_paid' => $order->transactions()->completed()->payments()->sum('amount'),
            'total_refunded' => $order->transactions()->refunds()->sum('amount'),
            'remaining_balance' => $order->remaining_balance,
            'payment_status' => $this->getPaymentStatus($order),
            'transactions' => $order->transactions()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
    }

    /**
     * Example 6: Get payment status label
     */
    private function getPaymentStatus(Order $order)
    {
        $totalPaid = $order->total_paid;

        if ($totalPaid == 0) {
            return 'unpaid';
        } elseif ($totalPaid < $order->total_amount) {
            return 'partially_paid';
        } else {
            return 'paid';
        }
    }

    /**
     * Example 7: Simulate payment gateway processing
     */
    private function processWithGateway(Transaction $transaction, array $data)
    {
        // This would integrate with real payment gateway (Stripe, PayPal, etc.)
        // For demo purposes, we simulate success

        return [
            'success' => true,
            'transaction_id' => 'gw_'.uniqid(),
            'message' => 'Payment processed successfully',
            'processed_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Example 8: Efficient query to get transaction statistics
     */
    public function getTransactionStats($startDate, $endDate)
    {
        return [
            'overview' => Transaction::dateRange($startDate, $endDate)
                ->select(
                    DB::raw('type'),
                    DB::raw('status'),
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(amount) as total_amount')
                )
                ->groupBy('type', 'status')
                ->get(),

            'by_payment_method' => Transaction::payments()
                ->completed()
                ->dateRange($startDate, $endDate)
                ->select(
                    'payment_method',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(amount) as total'),
                    DB::raw('AVG(amount) as average')
                )
                ->groupBy('payment_method')
                ->get(),

            'daily_totals' => Transaction::completed()
                ->dateRange($startDate, $endDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(CASE WHEN type = "payment" THEN amount ELSE 0 END) as payments'),
                    DB::raw('SUM(CASE WHEN type = "refund" THEN amount ELSE 0 END) as refunds'),
                    DB::raw('COUNT(*) as transaction_count')
                )
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get(),
        ];
    }

    /**
     * Example 9: Find transactions with N+1 fix
     */
    public function getTransactionsWithDetails($filters = [])
    {
        return Transaction::with(['order.items.product', 'user'])
            ->when(isset($filters['status']), fn ($q) => $q->where('status', $filters['status']))
            ->when(isset($filters['type']), fn ($q) => $q->where('type', $filters['type']))
            ->when(isset($filters['user_id']), fn ($q) => $q->where('user_id', $filters['user_id']))
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Example 10: Bulk transaction processing
     */
    public function processBulkTransactions(array $transactionIds)
    {
        $results = [
            'processed' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        Transaction::whereIn('id', $transactionIds)
            ->where('status', 'pending')
            ->chunk(50, function ($transactions) use (&$results) {
                foreach ($transactions as $transaction) {
                    try {
                        $this->processOrderPayment(
                            $transaction->order,
                            [
                                'amount' => $transaction->amount,
                                'payment_method' => $transaction->payment_method,
                            ]
                        );
                        $results['processed']++;
                    } catch (\Exception $e) {
                        $results['failed']++;
                        $results['errors'][] = [
                            'transaction_id' => $transaction->id,
                            'error' => $e->getMessage(),
                        ];
                    }
                }
            });

        return $results;
    }
}
