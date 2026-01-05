<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Inertia\Inertia;
use Inertia\Response;

class CurriculumPageController extends Controller
{
    public function show(Course $course): Response
    {
        // Ensure the teacher owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Load modules with lessons, ordered
        $modules = $course->modules()
            ->orderBy('order')
            ->with(['lessons' => fn ($q) => $q->orderBy('order')])
            ->get()
            ->map(fn ($module) => [
                'id' => $module->id,
                'title' => $module->title,
                'description' => $module->description,
                'order' => $module->order,
                'is_published' => $module->is_published,
                'lessons' => $module->lessons->map(fn ($lesson) => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'slug' => $lesson->slug,
                    'type' => $lesson->type,
                    'content' => $lesson->content,
                    'video_url' => $lesson->video_url,
                    'video_provider' => $lesson->video_provider,
                    'duration_minutes' => $lesson->duration_minutes,
                    'order' => $lesson->order,
                    'is_free' => $lesson->is_free,
                    'is_published' => $lesson->is_published,
                ]),
            ]);

        return Inertia::render('Teacher/Curriculum/Index', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
            ],
            'modules' => $modules,
        ]);
    }
}
