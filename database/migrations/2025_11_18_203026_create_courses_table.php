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

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->index();
            $table->string('slug', 255)->unique()->index();
            $table->string('subtitle', 255)->nullable();
            $table->longText('description');
            $table->text('objectives')->nullable();
            $table->text('requirements')->nullable();
            $table->enum('level', ["beginner","intermediate","advanced"])->default('beginner');
            $table->string('language', 10)->default('en');
            $table->foreignId('instructor_id')->constrained('users');
            $table->foreignId('category_id')->constrained();
            $table->string('thumbnail', 500)->nullable();
            $table->string('preview_video', 500)->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->enum('status', ["draft","pending","published","archived"])->default('draft');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->integer('lessons_count')->default(0);
            $table->integer('students_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('has_certificate')->default(false);
            $table->boolean('allow_reviews')->default(true);
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->index(['instructor_id', 'status']);
            $table->index(['category_id', 'is_published']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
