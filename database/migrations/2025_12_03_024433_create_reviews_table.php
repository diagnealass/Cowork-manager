<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('space_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned();
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->index('space_id');
            $table->index('rating');
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
