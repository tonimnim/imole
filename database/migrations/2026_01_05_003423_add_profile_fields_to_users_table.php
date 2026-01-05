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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('name');
            $table->string('headline')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('headline');
            $table->json('expertise')->nullable()->after('bio');
            $table->string('website')->nullable()->after('expertise');
            $table->string('twitter')->nullable()->after('website');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('youtube')->nullable()->after('linkedin');
            $table->string('phone')->nullable()->after('youtube');
            $table->string('location')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'headline',
                'bio',
                'expertise',
                'website',
                'twitter',
                'linkedin',
                'youtube',
                'phone',
                'location',
            ]);
        });
    }
};
