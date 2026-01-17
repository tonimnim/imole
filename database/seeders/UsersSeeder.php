<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Always create the admin user
        $this->createAdmins();

        // Only seed test users in non-production environments
        if (app()->environment('local', 'development', 'testing')) {
            $this->createTeachers();
            $this->createStudents();
        }
    }

    /**
     * Create admin users
     */
    private function createAdmins(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@imoleafrika.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('!Joan0790144'),
            ]
        );

        if (! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        $this->command->info('✓ Admin user ready');
    }

    /**
     * Create teacher users
     */
    private function createTeachers(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Dr. Amara Okafor',
                'email' => 'amara.okafor@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'James Anderson',
                'email' => 'james.anderson@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Linda Martinez',
                'email' => 'linda.martinez@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'David Thompson',
                'email' => 'david.thompson@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Emily Williams',
                'email' => 'emily.williams@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'robert.brown@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jennifer Davis',
                'email' => 'jennifer.davis@imoleafrica.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($teachers as $teacher) {
            $user = User::create($teacher);
            $user->assignRole('teacher');
        }

        $this->command->info('✓ Created '.count($teachers).' teacher users');
    }

    /**
     * Create student users
     */
    private function createStudents(): void
    {
        $students = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob.wilson@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Carol Martinez',
                'email' => 'carol.martinez@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Daniel Garcia',
                'email' => 'daniel.garcia@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Eva Rodriguez',
                'email' => 'eva.rodriguez@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Frank Miller',
                'email' => 'frank.miller@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Grace Lee',
                'email' => 'grace.lee@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Henry Taylor',
                'email' => 'henry.taylor@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Isabella Moore',
                'email' => 'isabella.moore@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jack Anderson',
                'email' => 'jack.anderson@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Kate Thompson',
                'email' => 'kate.thompson@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Leo White',
                'email' => 'leo.white@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Maria Harris',
                'email' => 'maria.harris@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Nathan Clark',
                'email' => 'nathan.clark@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Olivia Lewis',
                'email' => 'olivia.lewis@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Peter Walker',
                'email' => 'peter.walker@student.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Quinn Hall',
                'email' => 'quinn.hall@student.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($students as $student) {
            $user = User::create($student);
            $user->assignRole('student');
        }

        $this->command->info('✓ Created '.count($students).' student users');
    }
}
