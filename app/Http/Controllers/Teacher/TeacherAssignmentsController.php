<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Inertia\Inertia;
use Inertia\Response;

class TeacherAssignmentsController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $assignments = Assignment::whereHas('course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['course:id,title,slug', 'lesson:id,title'])
            ->withCount('assignmentSubmissions')
            ->latest()
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'course' => $a->course->title,
                'courseId' => $a->course->id,
                'lesson' => $a->lesson?->title ?? 'Standalone',
                'maxScore' => $a->max_score,
                'dueDate' => $a->due_date?->format('M d, Y'),
                'submissionsCount' => $a->assignment_submissions_count,
                'isPublished' => $a->is_published,
                'createdAt' => $a->created_at->format('M d, Y'),
            ]);

        // Get pending submissions for grading
        $pendingSubmissions = AssignmentSubmission::whereHas('assignment.course', fn ($q) => $q->where('instructor_id', $user->id))
            ->where('status', 'submitted')
            ->with(['assignment:id,title,max_score', 'user:id,name,email'])
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'assignment' => $s->assignment->title,
                'assignmentId' => $s->assignment->id,
                'maxScore' => $s->assignment->max_score,
                'student' => $s->user->name,
                'studentEmail' => $s->user->email,
                'submittedAt' => $s->created_at->diffForHumans(),
            ]);

        return Inertia::render('Teacher/Assignments/Index', [
            'assignments' => $assignments,
            'pendingSubmissions' => $pendingSubmissions,
        ]);
    }
}
