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
        Schema::table('announcements', function (Blueprint $table) {
            // Make course_id nullable for platform-wide announcements
            $table->foreignId('course_id')->nullable()->change();

            // Make instructor_id nullable for admin announcements
            $table->foreignId('instructor_id')->nullable()->change();

            // Add new fields for admin announcements
            $table->enum('type', ['info', 'warning', 'urgent'])->default('info')->after('content');
            $table->enum('target_audience', ['all', 'students', 'teachers'])->default('all')->after('type');
            $table->timestamp('expires_at')->nullable()->after('published_at');

            // Add index for better query performance
            $table->index(['is_published', 'target_audience', 'published_at', 'expires_at'], 'announcements_visibility_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('announcements_visibility_idx');
            $table->dropColumn(['type', 'target_audience', 'expires_at']);
        });
    }
};
