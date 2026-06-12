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
            $table->foreignId('trip_id')->constrained('trips')->restrictOnDelete();
            $table->string('reference', 30)->unique();          // BK-20260415-ABC123
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 20);
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);
            $table->date('travel_date');
            $table->enum('payment_method', ['credit_card', 'visa', 'meeza', 'instapay', 'vodafone_cash', 'paymob']);
            $table->decimal('total_price', 10, 2);
            $table->decimal('paid_amount_egp', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['confirmed', 'cancelled', 'completed'])->default('confirmed');
            $table->timestamp('confirmed_at')->nullable();
            $table->string('paymob_order_id')->nullable();
            $table->string('paymob_transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
