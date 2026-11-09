<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 30)->unique();
            $table->foreignId('showtime_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->json('seats'); // ['A1', 'A2']
            $table->unsignedTinyInteger('seat_count');
            $table->decimal('ticket_price', 10, 2);
            $table->decimal('ticket_subtotal', 10, 2);
            $table->decimal('snack_subtotal', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('QRIS');
            $table->enum('payment_status', ['pending', 'confirmed', 'cancelled'])->default('confirmed');
            $table->string('barcode', 50)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
