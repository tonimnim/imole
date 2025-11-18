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
        Schema::disableForeignKeyConstraints();

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->enum('payment_method', ["card","bank","ussd","mobile_money","qr"])->default('card');
            $table->string('paystack_reference', 255)->unique()->index();
            $table->string('paystack_access_code', 255)->nullable();
            $table->string('paystack_authorization_code', 255)->nullable();
            $table->string('transaction_id', 255)->unique()->nullable()->index();
            $table->string('reference_code', 100)->unique();
            $table->string('gateway_response', 255)->nullable();
            $table->string('channel', 50)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->enum('status', ["pending","success","failed","abandoned","refunded"])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('customer_email', 255);
            $table->string('customer_code', 100)->nullable();
            $table->json('metadata')->nullable();
            $table->index(['user_id', 'status']);
            $table->index('paystack_reference');
            $table->index(['status', 'created_at']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
