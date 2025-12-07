<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('space_id')->constrained()->onDelete('cascade');
            $table->string('booking_number')->unique();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->decimal('total_hours', 8, 2);
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'completed'
            ])->default('pending');
            $table->enum('payment_status', [
                'pending',
                'paid',
                'refunded',
                'failed'
            ])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->dateTime('check_in_at')->nullable();
            $table->dateTime('check_out_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('space_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index(['start_datetime', 'end_datetime']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
