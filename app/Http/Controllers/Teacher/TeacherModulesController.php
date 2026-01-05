<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Inertia\Inertia;
use Inertia\Response;

class TeacherModulesController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $modules = Module::whereHas('course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['course:id,title,slug'])
            ->withCount('lessons')
            ->latest()
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'title' => $m->title,
                'description' => $m->description,
                'course' => $m->course->title,
                'courseId' => $m->course->id,
                'lessonsCount' => $m->lessons_count,
                'order' => $m->order,
                'isPublished' => $m->is_published,
                'createdAt' => $m->created_at->format('M d, Y'),
            ]);

        return Inertia::render('Teacher/Modules/Index', [
            'modules' => $modules,
        ]);
    }
}
