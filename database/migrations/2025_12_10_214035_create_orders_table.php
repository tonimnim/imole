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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['mpesa', 'card'])->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('payment_reference')->nullable(); // M-Pesa transaction ID
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('order_number');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
