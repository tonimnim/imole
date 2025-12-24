<?php

namespace App\Http\Controllers;

use App\Events\StudentEnrolled;
use App\Http\Requests\EnrollmentStoreRequest;
use App\Jobs\SendEnrollmentConfirmation;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function store(EnrollmentStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['enrollment_status'] = 'active';
        $validated['enrolled_at'] = now();

        $enrollment = Enrollment::create($validated);

        SendEnrollmentConfirmation::dispatch($enrollment);

        StudentEnrolled::dispatch($enrollment);

        return redirect()
            ->route('courses.show', ['course' => $enrollment->course])
            ->with('success', 'Successfully enrolled!');
    }

    public function show(Request $request, Enrollment $enrollment): View
    {
        abort_unless(
            $enrollment->user_id === auth()->id() || auth()->user()?->hasRole('admin'),
            403
        );

        return view('enrollment.show', [
            'enrollment' => $enrollment,
        ]);
    }
}
