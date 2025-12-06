<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories first
        $agriculture = Category::create([
            'name' => 'Agriculture',
            'slug' => 'agriculture',
            'description' => 'Learn modern farming techniques and agricultural best practices',
            'icon' => '🌾',
            'parent_id' => null,
            'order' => 1,
            'is_active' => true,
        ]);

        $technology = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Master technology skills for the digital age',
            'icon' => '💻',
            'parent_id' => null,
            'order' => 2,
            'is_active' => true,
        ]);

        // Get or create instructors
        $instructor1 = User::where('email', 'sarah.johnson@imoleafrica.com')->first();
        $instructor2 = User::where('email', 'michael.chen@imoleafrica.com')->first();

        // Course 1: Sustainable Farming Techniques
        Course::create([
            'title' => 'Sustainable Farming Techniques for Modern Agriculture',
            'slug' => 'sustainable-farming-techniques',
            'subtitle' => 'Master eco-friendly farming methods to increase crop yield and protect the environment',
            'description' => 'This comprehensive course teaches you sustainable farming practices that are both environmentally friendly and economically viable. Learn how to implement crop rotation, natural pest control, water conservation, and soil management techniques that will transform your farming operations. Perfect for both small-scale and commercial farmers looking to adopt modern sustainable practices.',
            'objectives' => json_encode([
                'Understand the principles of sustainable agriculture',
                'Implement effective crop rotation strategies',
                'Master natural pest control methods',
                'Learn water conservation and irrigation techniques',
                'Practice soil health management',
                'Adopt organic farming practices',
            ]),
            'requirements' => json_encode([
                'Basic understanding of farming',
                'Access to farmland (optional but recommended)',
                'Willingness to learn and implement new techniques',
            ]),
            'level' => 'beginner',
            'language' => 'English',
            'instructor_id' => $instructor1?->id ?? 3,
            'category_id' => $agriculture->id,
            'thumbnail' => null,
            'preview_video' => null,
            'price' => 0,
            'currency' => 'KES',
            'discount_price' => null,
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
            'duration_minutes' => 480,
            'lessons_count' => 24,
            'students_count' => 1234,
            'reviews_count' => 89,
            'average_rating' => 4.8,
            'is_featured' => true,
            'has_certificate' => true,
            'allow_reviews' => true,
            'meta_title' => 'Sustainable Farming Techniques - Free Online Course',
            'meta_description' => 'Learn sustainable farming techniques for modern agriculture. Free course with certificate.',
        ]);

        // Course 2: Introduction to Web Development
        Course::create([
            'title' => 'Introduction to Web Development: HTML, CSS & JavaScript',
            'slug' => 'introduction-to-web-development',
            'subtitle' => 'Build your first website from scratch using HTML, CSS, and JavaScript',
            'description' => 'Start your journey into web development with this beginner-friendly course. Learn the fundamental technologies that power the web: HTML for structure, CSS for styling, and JavaScript for interactivity. By the end of this course, you will have built several real-world projects including a personal portfolio website, a landing page, and an interactive web application. No prior coding experience required!',
            'objectives' => json_encode([
                'Master HTML fundamentals and semantic markup',
                'Style websites beautifully with CSS',
                'Add interactivity with JavaScript',
                'Build responsive websites that work on all devices',
                'Understand web development best practices',
                'Deploy your website to the internet',
                'Create a professional portfolio',
            ]),
            'requirements' => json_encode([
                'A computer with internet access',
                'No prior programming experience needed',
                'Passion for learning and building websites',
            ]),
            'level' => 'beginner',
            'language' => 'English',
            'instructor_id' => $instructor2?->id ?? 4,
            'category_id' => $technology->id,
            'thumbnail' => null,
            'preview_video' => null,
            'price' => 2500,
            'currency' => 'KES',
            'discount_price' => 1500,
            'status' => 'published',
            'is_published' => true,
            'published_at' => now(),
            'duration_minutes' => 720,
            'lessons_count' => 36,
            'students_count' => 2156,
            'reviews_count' => 178,
            'average_rating' => 4.9,
            'is_featured' => true,
            'has_certificate' => true,
            'allow_reviews' => true,
            'meta_title' => 'Learn Web Development - HTML, CSS, JavaScript Course',
            'meta_description' => 'Start your web development journey. Learn HTML, CSS, and JavaScript from scratch.',
        ]);
    }
}
