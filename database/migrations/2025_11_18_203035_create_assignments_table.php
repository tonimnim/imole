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

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('lesson_id')->nullable()->constrained();
            $table->string('title', 255);
            $table->longText('description');
            $table->text('instructions')->nullable();
            $table->json('attachments')->nullable();
            $table->integer('max_score')->default(100);
            $table->integer('max_file_size_mb')->default(10);
            $table->string('allowed_file_types', 255)->nullable();
            $table->timestamp('due_date')->nullable();
            $table->boolean('late_submission_allowed')->default(true);
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
