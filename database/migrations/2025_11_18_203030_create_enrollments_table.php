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

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->timestamp('enrolled_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->decimal('price_paid', 10, 2)->default(0);
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled'])->default('active');
            $table->unique(['user_id', 'course_id']);
            $table->index(['course_id', 'status']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
