<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class CurriculumPageController extends Controller
{
    public function show(Course $course): View
    {
        // Ensure the teacher owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('teacher.curriculum', [
            'course' => $course,
        ]);
    }
}
