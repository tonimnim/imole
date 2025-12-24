<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Module;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Resource;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompleteLearningCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing course if it exists
        $existingCourse = Course::where('slug', 'complete-laravel-mastery')->first();
        if ($existingCourse) {
            $this->command->warn('🗑️  Deleting existing course and all related data...');

            // Delete all related records first (in correct order due to foreign keys)
            // Delete child records of lessons first
            foreach ($existingCourse->lessons as $lesson) {
                $lesson->resources()->delete();
                $lesson->comments()->delete();
                $lesson->lessonProgresses()->delete();
            }

            // Delete quiz attempts and questions
            foreach ($existingCourse->quizzes as $quiz) {
                $quiz->quizAttempts()->delete();
                $quiz->questions()->delete();
            }

            // Delete assignment submissions first, then assignments
            foreach ($existingCourse->assignments as $assignment) {
                $assignment->assignmentSubmissions()->delete();
            }
            $existingCourse->assignments()->delete();

            // Now delete quizzes and lessons
            $existingCourse->quizzes()->delete();
            $existingCourse->lessons()->delete();

            // Delete modules, enrollments, reviews, and announcements
            $existingCourse->modules()->delete();
            $existingCourse->enrollments()->delete();
            $existingCourse->reviews()->delete();
            $existingCourse->announcements()->delete();

            $existingCourse->delete();
        }

        // Get or create instructor
        $instructor = User::where('email', 'instructor@imoleafrica.com')->first()
            ?? User::factory()->create([
                'name' => 'Dr. Jane Smith',
                'email' => 'instructor@imoleafrica.com',
            ]);

        $instructor->assignRole('teacher');

        // Get or create category
        $category = Category::firstOrCreate(
            ['slug' => 'programming'],
            [
                'name' => 'Programming',
                'description' => 'Learn programming languages and frameworks',
                'is_active' => true,
                'order' => 1,
            ]
        );

        // Create the course
        $course = Course::create([
            'title' => 'Complete Laravel Mastery: From Beginner to Professional',
            'slug' => 'complete-laravel-mastery',
            'subtitle' => 'Build modern web applications with Laravel, Vue.js, and Tailwind CSS',
            'description' => 'Master Laravel framework from the ground up. This comprehensive course covers everything from basic PHP concepts to advanced Laravel features including authentication, authorization, API development, testing, and deployment. Build real-world projects and learn industry best practices.',
            'objectives' => json_encode([
                'Understand Laravel architecture and MVC pattern',
                'Build RESTful APIs with Laravel',
                'Implement authentication and authorization',
                'Write comprehensive tests with PHPUnit and Pest',
                'Deploy Laravel applications to production',
                'Work with databases using Eloquent ORM',
                'Build modern UIs with Blade, Vue.js, and Tailwind',
            ]),
            'requirements' => json_encode([
                'Basic understanding of PHP',
                'Familiarity with HTML, CSS, and JavaScript',
                'A computer with internet connection',
                'Willingness to learn and practice',
            ]),
            'level' => 'intermediate',
            'language' => 'en',
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'thumbnail' => 'https://via.placeholder.com/1920x1080/4F46E5/ffffff?text=Laravel+Mastery',
            'preview_video' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE',
            'price' => 4999.00,
            'currency' => 'KES',
            'discount_price' => 2999.00,
            'status' => 'published',
            'is_published' => true,
            'published_at' => now()->subDays(30),
            'duration_minutes' => 1800, // 30 hours
            'is_featured' => true,
            'has_certificate' => true,
            'allow_reviews' => true,
            'meta_title' => 'Complete Laravel Mastery Course - Learn Laravel Development',
            'meta_description' => 'Master Laravel development with our comprehensive course. Build real applications, learn best practices, and become a professional Laravel developer.',
        ]);

        // Module 1: Laravel Fundamentals
        $module1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 1: Laravel Fundamentals',
            'description' => 'Get started with Laravel basics, installation, and core concepts',
            'order' => 1,
            'is_published' => true,
        ]);

        // Module 1 Lessons
        $lesson1_1 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module1->id,
            'title' => 'Welcome to Laravel',
            'slug' => 'welcome-to-laravel',
            'content' => '<h2>Welcome to Complete Laravel Mastery!</h2><p>In this lesson, we\'ll introduce you to Laravel, one of the most popular PHP frameworks. We\'ll cover what makes Laravel special and why it\'s the framework of choice for thousands of developers worldwide.</p><h3>What You\'ll Learn:</h3><ul><li>What is Laravel and why use it?</li><li>Laravel ecosystem overview</li><li>Course structure and learning path</li><li>Setting up your development environment</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE',
            'video_provider' => 'youtube',
            'video_duration' => 15,
            'type' => 'video',
            'duration_minutes' => 15,
            'order' => 1,
            'is_free' => true,
            'is_published' => true,
        ]);

        Resource::create([
            'lesson_id' => $lesson1_1->id,
            'title' => 'Laravel Installation Guide',
            'file_name' => 'laravel-installation-guide.pdf',
            'file_path' => 'resources/laravel-installation-guide.pdf',
            'file_type' => 'pdf',
            'file_size' => 2048000,
            'order' => 1,
        ]);

        $lesson1_2 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module1->id,
            'title' => 'Installing Laravel & Development Environment',
            'slug' => 'installing-laravel-development-environment',
            'content' => '<h2>Setting Up Your Development Environment</h2><p>Learn how to install Laravel using Composer, set up Laravel Herd or Valet, and configure your IDE for maximum productivity.</p><h3>Topics Covered:</h3><ul><li>Installing PHP and Composer</li><li>Using Laravel Installer</li><li>Setting up Laravel Herd (macOS/Windows)</li><li>Configuring VS Code with Laravel extensions</li><li>Understanding the Laravel directory structure</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=XKudFg7S0dY',
            'video_provider' => 'youtube',
            'video_duration' => 25,
            'type' => 'video',
            'duration_minutes' => 25,
            'order' => 2,
            'is_free' => true,
            'is_published' => true,
        ]);

        $lesson1_3 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module1->id,
            'title' => 'Understanding MVC Architecture',
            'slug' => 'understanding-mvc-architecture',
            'content' => '<h2>The MVC Pattern in Laravel</h2><p>Model-View-Controller is the architectural pattern that Laravel is built upon. Understanding MVC is crucial for building well-structured applications.</p><h3>Key Concepts:</h3><ul><li>What is MVC?</li><li>Models: Working with data</li><li>Views: Presenting data to users</li><li>Controllers: Handling business logic</li><li>How MVC works in Laravel</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=pCy9c77yPxQ',
            'video_provider' => 'youtube',
            'video_duration' => 20,
            'type' => 'video',
            'duration_minutes' => 20,
            'order' => 3,
            'is_free' => false,
            'is_published' => true,
        ]);

        $lesson1_4 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module1->id,
            'title' => 'Routing Basics',
            'slug' => 'routing-basics',
            'content' => '<h2>Laravel Routing</h2><p>Routes are the entry points to your application. Learn how to define routes, work with route parameters, and organize your routes effectively.</p><h3>What We\'ll Cover:</h3><ul><li>Defining basic routes</li><li>Route parameters and constraints</li><li>Named routes</li><li>Route groups</li><li>Route model binding</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=v11dIp7nRKg',
            'video_provider' => 'youtube',
            'video_duration' => 30,
            'type' => 'video',
            'duration_minutes' => 30,
            'order' => 4,
            'is_free' => false,
            'is_published' => true,
        ]);

        // Quiz for Module 1
        $quiz1 = Quiz::create([
            'course_id' => $course->id,
            'lesson_id' => null, // Module-level quiz
            'title' => 'Laravel Fundamentals Quiz',
            'description' => 'Test your understanding of Laravel basics and core concepts',
            'duration_minutes' => 15,
            'passing_score' => 70,
            'max_attempts' => 3,
            'shuffle_questions' => true,
            'show_correct_answers' => true,
            'is_published' => true,
            'order' => 1,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What architectural pattern does Laravel use?',
            'question_type' => 'multiple_choice',
            'options' => json_encode([
                'MVC (Model-View-Controller)',
                'MVP (Model-View-Presenter)',
                'MVVM (Model-View-ViewModel)',
                'Layered Architecture',
            ]),
            'correct_answer' => 'MVC (Model-View-Controller)',
            'explanation' => 'Laravel uses the MVC (Model-View-Controller) architectural pattern to separate application logic.',
            'points' => 10,
            'order' => 1,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which file contains all the routes for web requests in Laravel?',
            'question_type' => 'multiple_choice',
            'options' => json_encode([
                'routes/web.php',
                'routes/api.php',
                'app/Http/routes.php',
                'config/routes.php',
            ]),
            'correct_answer' => 'routes/web.php',
            'explanation' => 'The routes/web.php file contains all the routes for web requests in a Laravel application.',
            'points' => 10,
            'order' => 2,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Laravel is built on top of the PHP language.',
            'question_type' => 'true_false',
            'options' => json_encode(['True', 'False']),
            'correct_answer' => 'True',
            'explanation' => 'Laravel is a PHP framework, meaning it is built using the PHP programming language.',
            'points' => 5,
            'order' => 3,
        ]);

        // Module 2: Database & Eloquent ORM
        $module2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 2: Database & Eloquent ORM',
            'description' => 'Master database interactions with Laravel\'s powerful Eloquent ORM',
            'order' => 2,
            'is_published' => true,
        ]);

        // Module 2 Lessons
        $lesson2_1 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module2->id,
            'title' => 'Database Configuration & Migrations',
            'slug' => 'database-configuration-migrations',
            'content' => '<h2>Working with Databases in Laravel</h2><p>Learn how to configure database connections and use migrations to version control your database schema.</p><h3>Topics:</h3><ul><li>Configuring database connections</li><li>Creating migrations</li><li>Running migrations</li><li>Rollbacks and fresh migrations</li><li>Migration best practices</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=9iyLR0D4w_k',
            'video_provider' => 'youtube',
            'video_duration' => 35,
            'type' => 'video',
            'duration_minutes' => 35,
            'order' => 1,
            'is_free' => false,
            'is_published' => true,
        ]);

        $lesson2_2 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module2->id,
            'title' => 'Introduction to Eloquent ORM',
            'slug' => 'introduction-to-eloquent-orm',
            'content' => '<h2>Eloquent: Laravel\'s ORM</h2><p>Eloquent makes database interactions elegant and intuitive. Learn how to create models, perform CRUD operations, and work with relationships.</p><h3>What You\'ll Learn:</h3><ul><li>Creating Eloquent models</li><li>CRUD operations (Create, Read, Update, Delete)</li><li>Query scopes</li><li>Mass assignment protection</li><li>Model events</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=VbHb0_x7-so',
            'video_provider' => 'youtube',
            'video_duration' => 40,
            'type' => 'video',
            'duration_minutes' => 40,
            'order' => 2,
            'is_free' => false,
            'is_published' => true,
        ]);

        $lesson2_3 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module2->id,
            'title' => 'Eloquent Relationships',
            'slug' => 'eloquent-relationships',
            'content' => '<h2>Mastering Eloquent Relationships</h2><p>Learn how to define and work with relationships between models including one-to-one, one-to-many, many-to-many, and polymorphic relationships.</p><h3>Relationship Types:</h3><ul><li>One to One (hasOne, belongsTo)</li><li>One to Many (hasMany, belongsTo)</li><li>Many to Many (belongsToMany)</li><li>Has Many Through</li><li>Polymorphic relationships</li><li>Eager loading and N+1 problem</li></ul>',
            'video_url' => 'https://www.youtube.com/watch?v=v7Ej6GeLJCo',
            'video_provider' => 'youtube',
            'video_duration' => 50,
            'type' => 'video',
            'duration_minutes' => 50,
            'order' => 3,
            'is_free' => false,
            'is_published' => true,
        ]);

        // Assignment for Module 2
        $assignment1 = Assignment::create([
            'course_id' => $course->id,
            'lesson_id' => $lesson2_3->id,
            'title' => 'Build a Blog Database Schema',
            'description' => 'Create a complete database schema for a blog application using migrations and Eloquent models.',
            'instructions' => '<h3>Assignment Instructions</h3><p>Create the following models and migrations:</p><ol><li>User model (provided by Laravel)</li><li>Post model with: title, slug, content, published_at, user_id</li><li>Category model with: name, slug</li><li>Tag model with: name, slug</li><li>Comment model with: content, user_id, post_id</li></ol><h3>Requirements:</h3><ul><li>Set up proper relationships between models</li><li>Implement a many-to-many relationship between Posts and Tags</li><li>Add appropriate fillable properties and casts</li><li>Include factories and seeders for testing</li></ul><h3>Submission:</h3><p>Submit a ZIP file containing your migrations, models, factories, and a screenshot of your database schema.</p>',
            'attachments' => json_encode([]),
            'max_score' => 100,
            'max_file_size_mb' => 10,
            'allowed_file_types' => json_encode(['zip', 'rar']),
            'due_date' => now()->addDays(7),
            'late_submission_allowed' => true,
            'is_published' => true,
            'order' => 1,
        ]);

        // Module 3: Authentication & Authorization
        $module3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 3: Authentication & Authorization',
            'description' => 'Implement secure user authentication and role-based access control',
            'order' => 3,
            'is_published' => true,
        ]);

        $lesson3_1 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module3->id,
            'title' => 'Laravel Breeze Setup',
            'slug' => 'laravel-breeze-setup',
            'content' => '<h2>Getting Started with Laravel Breeze</h2><p>Laravel Breeze provides a minimal, simple implementation of Laravel\'s authentication features.</p>',
            'video_url' => 'https://www.youtube.com/watch?v=v_lJW7YY1x4',
            'video_provider' => 'youtube',
            'video_duration' => 30,
            'type' => 'video',
            'duration_minutes' => 30,
            'order' => 1,
            'is_free' => false,
            'is_published' => true,
        ]);

        $lesson3_2 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module3->id,
            'title' => 'Gates and Policies',
            'slug' => 'gates-and-policies',
            'content' => '<h2>Authorization with Gates and Policies</h2><p>Learn how to implement fine-grained authorization in your Laravel applications.</p>',
            'video_url' => 'https://www.youtube.com/watch?v=kZOgH3-0Bko',
            'video_provider' => 'youtube',
            'video_duration' => 35,
            'type' => 'video',
            'duration_minutes' => 35,
            'order' => 2,
            'is_free' => false,
            'is_published' => true,
        ]);

        // Module 4: Building APIs
        $module4 = Module::create([
            'course_id' => $course->id,
            'title' => 'Module 4: RESTful API Development',
            'description' => 'Build robust RESTful APIs with Laravel Sanctum',
            'order' => 4,
            'is_published' => true,
        ]);

        $lesson4_1 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module4->id,
            'title' => 'API Resources & Collections',
            'slug' => 'api-resources-collections',
            'content' => '<h2>Building API Resources</h2><p>Learn how to transform your models into JSON responses using API Resources.</p>',
            'video_url' => 'https://www.youtube.com/watch?v=7wKP3kk0W8U',
            'video_provider' => 'youtube',
            'video_duration' => 40,
            'type' => 'video',
            'duration_minutes' => 40,
            'order' => 1,
            'is_free' => false,
            'is_published' => true,
        ]);

        $lesson4_2 = Lesson::create([
            'course_id' => $course->id,
            'module_id' => $module4->id,
            'title' => 'API Authentication with Sanctum',
            'slug' => 'api-authentication-sanctum',
            'content' => '<h2>Securing Your API</h2><p>Implement token-based authentication for your API using Laravel Sanctum.</p>',
            'video_url' => 'https://www.youtube.com/watch?v=MT-GJQIY3EU',
            'video_provider' => 'youtube',
            'video_duration' => 45,
            'type' => 'video',
            'duration_minutes' => 45,
            'order' => 2,
            'is_free' => false,
            'is_published' => true,
        ]);

        // Create some students and enroll them
        $students = User::factory()->count(5)->create();
        foreach ($students as $student) {
            $student->assignRole('student');

            // Enroll student in the course
            $enrollment = Enrollment::create([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'status' => 'active',
                'progress_percentage' => rand(0, 100),
                'enrolled_at' => now()->subDays(rand(1, 30)),
                'started_at' => now()->subDays(rand(1, 25)),
                'last_accessed_at' => now()->subDays(rand(0, 5)),
                'price_paid' => $course->discount_price ?? $course->price,
            ]);

            // Create lesson progress for some lessons
            $allLessons = $course->lessons;
            $completedCount = rand(1, $allLessons->count());

            $allLessons->take($completedCount)->each(function ($lesson) use ($student, $enrollment) {
                LessonProgress::create([
                    'user_id' => $student->id,
                    'lesson_id' => $lesson->id,
                    'enrollment_id' => $enrollment->id,
                    'is_completed' => true,
                    'completed_at' => now()->subDays(rand(0, 20)),
                    'time_spent_seconds' => rand(300, 3600),
                    'last_position_seconds' => $lesson->duration_minutes * 60,
                ]);
            });

            // Take quiz attempts
            QuizAttempt::create([
                'user_id' => $student->id,
                'quiz_id' => $quiz1->id,
                'score' => rand(60, 100),
                'total_points' => 25,
                'earned_points' => rand(15, 25),
                'answers' => json_encode([
                    '1' => 'MVC (Model-View-Controller)',
                    '2' => 'routes/web.php',
                    '3' => 'True',
                ]),
                'status' => 'completed',
                'is_passed' => true,
                'started_at' => now()->subDays(rand(1, 15)),
                'completed_at' => now()->subDays(rand(1, 14)),
                'attempt_number' => 1,
            ]);

            // Submit assignment (for some students)
            if (rand(0, 1)) {
                $isGraded = rand(0, 1);
                AssignmentSubmission::create([
                    'assignment_id' => $assignment1->id,
                    'user_id' => $student->id,
                    'content' => 'I have completed the blog database schema with all required models, migrations, and relationships. Please find the attached ZIP file.',
                    'file_path' => 'assignments/'.$student->id.'/blog-schema.zip',
                    'file_name' => 'blog-schema.zip',
                    'max_score' => $assignment1->max_score,
                    'status' => $isGraded ? 'graded' : 'submitted',
                    'score' => $isGraded ? rand(70, 100) : null,
                    'feedback' => $isGraded ? 'Great work! Your database schema is well-structured and follows Laravel conventions.' : null,
                    'submitted_at' => now()->subDays(rand(1, 10)),
                    'graded_at' => $isGraded ? now()->subDays(rand(0, 5)) : null,
                    'graded_by' => $isGraded ? $instructor->id : null,
                    'is_late' => false,
                ]);
            }
        }

        // Create course reviews
        Review::create([
            'course_id' => $course->id,
            'user_id' => $students[0]->id,
            'rating' => 5,
            'title' => 'Excellent Course!',
            'comment' => 'This course is fantastic! The instructor explains everything clearly and the projects are very practical. Highly recommended for anyone wanting to learn Laravel.',
            'is_approved' => true,
        ]);

        Review::create([
            'course_id' => $course->id,
            'user_id' => $students[1]->id,
            'rating' => 4,
            'title' => 'Very comprehensive',
            'comment' => 'Great content and well-structured. The only thing I would improve is adding more real-world examples.',
            'is_approved' => true,
        ]);

        // Create announcements
        Announcement::create([
            'course_id' => $course->id,
            'instructor_id' => $instructor->id,
            'title' => 'Welcome to the Course!',
            'content' => 'Welcome everyone! I\'m excited to have you in this Laravel Mastery course. Make sure to join our Discord community for discussions and support.',
            'is_published' => true,
            'published_at' => now()->subDays(30),
        ]);

        Announcement::create([
            'course_id' => $course->id,
            'instructor_id' => $instructor->id,
            'title' => 'New Module Released: API Development',
            'content' => 'Module 4 on RESTful API Development is now available! We\'ll be covering API Resources, Sanctum authentication, and more.',
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);

        // Create lesson comments
        Comment::create([
            'lesson_id' => $lesson1_1->id,
            'user_id' => $students[0]->id,
            'parent_id' => null,
            'content' => 'Great introduction! Very clear and engaging.',
            'is_approved' => true,
        ]);

        Comment::create([
            'lesson_id' => $lesson2_2->id,
            'user_id' => $students[1]->id,
            'parent_id' => null,
            'content' => 'Can you explain more about mass assignment protection?',
            'is_approved' => true,
        ]);

        $this->command->info('✅ Complete Laravel Mastery course created successfully!');
        $this->command->info("📚 Course ID: {$course->id}");
        $this->command->info("👨‍🏫 Instructor: {$instructor->name} ({$instructor->email})");
        $this->command->info('📖 Modules: 4');
        $this->command->info("📝 Lessons: {$course->lessons()->count()}");
        $this->command->info('❓ Quizzes: 1');
        $this->command->info('📋 Assignments: 1');
        $this->command->info('👥 Enrolled Students: 5');
    }
}
