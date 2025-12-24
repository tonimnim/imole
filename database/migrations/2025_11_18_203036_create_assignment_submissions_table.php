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

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->longText('content')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->integer('max_score');
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users');
            $table->timestamp('graded_at')->nullable();
            $table->timestamp('submitted_at');
            $table->boolean('is_late')->default(false);
            $table->enum('status', ['submitted', 'graded', 'returned', 'resubmitted'])->default('submitted');
            $table->index(['assignment_id', 'user_id']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
