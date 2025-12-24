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

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('module_id')->nullable()->constrained();
            $table->string('title', 255)->index();
            $table->string('slug', 255);
            $table->longText('content');
            $table->string('video_url', 500)->nullable();
            $table->enum('video_provider', ['youtube', 'vimeo', 'custom'])->nullable();
            $table->integer('video_duration')->nullable();
            $table->enum('type', ['video', 'text', 'quiz', 'assignment'])->default('video');
            $table->integer('duration_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_published')->default(false);
            $table->index(['course_id', 'order']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
