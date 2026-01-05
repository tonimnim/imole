<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Inertia\Inertia;
use Inertia\Response;

class TeacherLessonsController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $lessons = Lesson::whereHas('course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['course:id,title,slug', 'module:id,title'])
            ->latest()
            ->get()
            ->map(fn ($l) => [
                'id' => $l->id,
                'title' => $l->title,
                'type' => $l->type,
                'course' => $l->course->title,
                'courseId' => $l->course->id,
                'module' => $l->module?->title ?? 'No Module',
                'duration' => $l->duration_minutes,
                'isFree' => $l->is_free,
                'isPublished' => $l->is_published,
                'createdAt' => $l->created_at->format('M d, Y'),
            ]);

        return Inertia::render('Teacher/Lessons/Index', [
            'lessons' => $lessons,
        ]);
    }
}
