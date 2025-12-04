<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('address');
            $table->string('city', 100);
            $table->string('country', 100);
            $table->string('postal_code', 20);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('capacity')->unsigned();
            $table->enum('space_type', [
                'private_office',
                'shared_desk',
                'meeting_room',
                'entire_space'
            ]);
            $table->decimal('price_per_hour', 10, 2)->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('price_per_month', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->integer('min_booking_hours')->default(1);
            $table->integer('max_booking_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();

            $table->index('manager_id');
            $table->index('city');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('space_type');
            $table->index('rating_average');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spaces');
    }
};
