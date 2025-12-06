<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
        ]);
        $user->assignRole('teacher');
    }
}
