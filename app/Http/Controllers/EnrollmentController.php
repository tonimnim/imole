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
    public function store(EnrollmentStoreRequest $request): Response
    {
        $enrollment = Enrollment::create($request->validated());

        SendEnrollmentConfirmation::dispatch($enrollment);

        StudentEnrolled::dispatch($enrollment);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function show(Request $request, Enrollment $enrollment): Response
    {
        $enrollment = Enrollment::find($id);

        return view('enrollment.show', [
            'enrollment' => $enrollment,
        ]);
    }
}
