<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::with('user')->get();

        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'];
        $paymentGateways = ['stripe', 'paypal', 'square', null];

        foreach ($orders as $order) {
            $scenario = $this->getScenario();

            switch ($scenario) {
                case 'full_payment':
                    $this->createFullPayment($order, $paymentMethods, $paymentGateways);
                    break;

                case 'partial_payment':
                    $this->createPartialPayments($order, $paymentMethods, $paymentGateways);
                    break;

                case 'full_payment_with_refund':
                    $this->createPaymentWithRefund($order, $paymentMethods, $paymentGateways);
                    break;

                case 'pending_payment':
                    $this->createPendingPayment($order, $paymentMethods, $paymentGateways);
                    break;

                case 'failed_payment':
                    $this->createFailedPayment($order, $paymentMethods, $paymentGateways);
                    break;
            }
        }
    }

    /**
     * Determine scenario based on probability
     */
    private function getScenario(): string
    {
        $random = rand(1, 100);

        if ($random <= 60) {
            return 'full_payment'; // 60% - Most common
        } elseif ($random <= 75) {
            return 'partial_payment'; // 15%
        } elseif ($random <= 85) {
            return 'full_payment_with_refund'; // 10%
        } elseif ($random <= 95) {
            return 'pending_payment'; // 10%
        } else {
            return 'failed_payment'; // 5%
        }
    }

    /**
     * Scenario 1: Full payment (completed)
     */
    private function createFullPayment($order, $paymentMethods, $paymentGateways)
    {
        $paymentMethod = fake()->randomElement($paymentMethods);
        $gateway = in_array($paymentMethod, ['credit_card', 'debit_card', 'paypal'])
            ? fake()->randomElement(['stripe', 'paypal', 'square'])
            : null;

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $order->total_amount,
            'type' => 'payment',
            'payment_method' => $paymentMethod,
            'status' => 'completed',
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => $gateway ? 'ch_' . uniqid() : null,
            'gateway_response' => json_encode([
                'status' => 'success',
                'message' => 'Payment processed successfully',
                'card_last4' => $paymentMethod === 'credit_card' ? fake()->numerify('####') : null,
            ]),
            'notes' => 'Full payment for order ' . $order->order_number,
            'processed_at' => fake()->dateTimeBetween($order->created_at, 'now'),
            'created_at' => $order->created_at,
            'updated_at' => fake()->dateTimeBetween($order->created_at, 'now'),
        ]);

        // Update order status
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Scenario 2: Partial payments (multiple transactions)
     */
    private function createPartialPayments($order, $paymentMethods, $paymentGateways)
    {
        $remainingAmount = $order->total_amount;
        $paymentsCount = rand(2, 3);

        for ($i = 0; $i < $paymentsCount; $i++) {
            $isLastPayment = ($i === $paymentsCount - 1);

            // Last payment covers remaining amount
            if ($isLastPayment) {
                $amount = $remainingAmount;
            } else {
                // Random amount between 30-70% of remaining
                $percentage = fake()->randomFloat(2, 0.3, 0.7);
                $amount = round($remainingAmount * $percentage, 2);
            }

            $paymentMethod = fake()->randomElement($paymentMethods);
            $gateway = in_array($paymentMethod, ['credit_card', 'debit_card', 'paypal'])
                ? fake()->randomElement(['stripe', 'paypal', 'square'])
                : null;

            $createdAt = fake()->dateTimeBetween($order->created_at, 'now');

            Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'transaction_number' => 'TXN-' . strtoupper(uniqid()),
                'amount' => $amount,
                'type' => 'payment',
                'payment_method' => $paymentMethod,
                'status' => 'completed',
                'payment_gateway' => $gateway,
                'gateway_transaction_id' => $gateway ? 'ch_' . uniqid() : null,
                'gateway_response' => json_encode([
                    'status' => 'success',
                    'message' => 'Partial payment processed',
                ]),
                'notes' => 'Partial payment ' . ($i + 1) . '/' . $paymentsCount . ' for order ' . $order->order_number,
                'processed_at' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $remainingAmount -= $amount;
        }

        // Update order status to completed if fully paid
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Scenario 3: Full payment with refund
     */
    private function createPaymentWithRefund($order, $paymentMethods, $paymentGateways)
    {
        $paymentMethod = fake()->randomElement($paymentMethods);
        $gateway = in_array($paymentMethod, ['credit_card', 'debit_card', 'paypal'])
            ? fake()->randomElement(['stripe', 'paypal', 'square'])
            : null;

        // Payment date is after order creation
        $paymentDate = fake()->dateTimeBetween($order->created_at, 'now');

        // Create payment transaction
        $payment = Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $order->total_amount,
            'type' => 'payment',
            'payment_method' => $paymentMethod,
            'status' => 'refunded',
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => $gateway ? 'ch_' . uniqid() : null,
            'gateway_response' => json_encode([
                'status' => 'success',
                'message' => 'Payment processed successfully',
            ]),
            'notes' => 'Payment for order ' . $order->order_number,
            'processed_at' => $paymentDate,
            'refunded_at' => fake()->dateTimeBetween($paymentDate, 'now'),
            'created_at' => $paymentDate,
            'updated_at' => fake()->dateTimeBetween($paymentDate, 'now'),
        ]);

        // Create refund transaction (full or partial)
        $isFullRefund = fake()->boolean(70); // 70% full refund, 30% partial
        $refundAmount = $isFullRefund
            ? $order->total_amount
            : round($order->total_amount * fake()->randomFloat(2, 0.3, 0.9), 2);

        $refundReasons = [
            'Customer requested refund',
            'Product defect',
            'Wrong item shipped',
            'Delivery delay',
            'Changed mind',
            'Item not as described',
        ];

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $refundAmount,
            'type' => 'refund',
            'payment_method' => $paymentMethod,
            'status' => 'completed',
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => $gateway ? 'rf_' . uniqid() : null,
            'gateway_response' => json_encode([
                'status' => 'success',
                'message' => 'Refund processed successfully',
            ]),
            'notes' => fake()->randomElement($refundReasons),
            'processed_at' => fake()->dateTimeBetween($paymentDate, 'now'),
            'refunded_at' => fake()->dateTimeBetween($paymentDate, 'now'),
            'created_at' => fake()->dateTimeBetween($paymentDate, 'now'),
            'updated_at' => fake()->dateTimeBetween($paymentDate, 'now'),
        ]);

        // Update order status
        $order->update([
            'status' => $isFullRefund ? 'cancelled' : 'completed',
        ]);
    }

    /**
     * Scenario 4: Pending payment
     */
    private function createPendingPayment($order, $paymentMethods, $paymentGateways)
    {
        $paymentMethod = fake()->randomElement($paymentMethods);
        $gateway = in_array($paymentMethod, ['bank_transfer'])
            ? null
            : fake()->randomElement($paymentGateways);

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $order->total_amount,
            'type' => 'payment',
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => null,
            'gateway_response' => null,
            'notes' => $paymentMethod === 'bank_transfer'
                ? 'Awaiting bank transfer confirmation'
                : 'Payment authorization pending',
            'created_at' => fake()->dateTimeBetween($order->created_at, 'now'),
            'updated_at' => fake()->dateTimeBetween($order->created_at, 'now'),
        ]);

        // Keep order in pending/processing status
        $order->update([
            'status' => 'processing',
        ]);
    }

    /**
     * Scenario 5: Failed payment
     */
    private function createFailedPayment($order, $paymentMethods, $paymentGateways)
    {
        $paymentMethod = fake()->randomElement(['credit_card', 'debit_card', 'paypal']);
        $gateway = fake()->randomElement(['stripe', 'paypal', 'square']);

        $failureReasons = [
            'Insufficient funds',
            'Card declined',
            'Invalid card number',
            'Card expired',
            'Payment gateway timeout',
            'Security check failed',
            'Daily limit exceeded',
        ];

        $failedAt = fake()->dateTimeBetween($order->created_at, 'now');

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $order->total_amount,
            'type' => 'payment',
            'payment_method' => $paymentMethod,
            'status' => 'failed',
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => null,
            'gateway_response' => json_encode([
                'status' => 'failed',
                'message' => fake()->randomElement($failureReasons),
                'error_code' => 'ERR_' . rand(1000, 9999),
            ]),
            'notes' => 'Payment attempt failed: ' . fake()->randomElement($failureReasons),
            'failed_at' => $failedAt,
            'created_at' => $failedAt,
            'updated_at' => $failedAt,
        ]);

        // Order remains in pending
        $order->update([
            'status' => 'pending',
        ]);
    }
}
