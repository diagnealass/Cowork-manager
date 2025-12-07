<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->enum('payment_method', ['stripe', 'paypal', 'bank_transfer']);
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded'
            ])->default('pending');
            $table->string('stripe_payment_intent_id')->nullable();
            $table->decimal('refund_amount', 10, 2)->default(0);
            $table->timestamp('refunded_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('booking_id');
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
