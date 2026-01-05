<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherCertificatesController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();
        $courseIds = $user->courses()->pluck('id');

        $certificatesQuery = Certificate::whereIn('course_id', $courseIds)
            ->with(['user:id,name,email,avatar', 'course:id,title']);

        // Filter by course
        if ($request->filled('course_id')) {
            $certificatesQuery->where('course_id', $request->course_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $certificatesQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $certificates = $certificatesQuery
            ->latest('issued_at')
            ->paginate(20)
            ->through(fn ($cert) => [
                'id' => $cert->id,
                'certificateNumber' => $cert->certificate_number,
                'student' => [
                    'id' => $cert->user->id,
                    'name' => $cert->user->name,
                    'email' => $cert->user->email,
                    'avatar' => $cert->user->avatar,
                    'avatarUrl' => $cert->user->avatar ? asset('storage/'.$cert->user->avatar) : null,
                ],
                'course' => [
                    'id' => $cert->course->id,
                    'title' => $cert->course->title,
                ],
                'issuedAt' => $cert->issued_at->format('M d, Y'),
                'validUntil' => $cert->valid_until?->format('M d, Y'),
                'filePath' => $cert->file_path,
            ]);

        // Stats
        $totalCertificates = Certificate::whereIn('course_id', $courseIds)->count();
        $thisMonth = Certificate::whereIn('course_id', $courseIds)
            ->whereMonth('issued_at', now()->month)
            ->whereYear('issued_at', now()->year)
            ->count();
        $coursesWithCerts = Certificate::whereIn('course_id', $courseIds)
            ->distinct('course_id')
            ->count('course_id');

        // Courses for filter
        $courses = $user->courses()->select('id', 'title')->get();

        return Inertia::render('Teacher/Certificates/Index', [
            'certificates' => $certificates,
            'stats' => [
                'total' => $totalCertificates,
                'thisMonth' => $thisMonth,
                'coursesWithCerts' => $coursesWithCerts,
            ],
            'courses' => $courses,
            'filters' => $request->only(['course_id', 'search']),
        ]);
    }
}
