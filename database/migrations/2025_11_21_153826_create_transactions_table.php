<?php

// database/migrations/2024_01_01_000004_create_transactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('transaction_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['payment', 'refund', 'adjustment'])->default('payment');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'])->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_gateway')->nullable(); // stripe, paypal, etc.
            $table->string('gateway_transaction_id')->nullable();
            $table->text('gateway_response')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->index('transaction_number');
            $table->index(['status', 'type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
