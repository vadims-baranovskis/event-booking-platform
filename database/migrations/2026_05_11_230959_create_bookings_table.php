<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create bookings table.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 8, 2);
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Drop bookings table.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};