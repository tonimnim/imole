<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentSubmissionStoreRequest;
use App\Http\Requests\AssignmentSubmissionUpdateRequest;
use App\Models\AssignmentSubmission;
use App\Notification\AssignmentGradedNotification;
use App\Notification\AssignmentSubmittedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AssignmentSubmissionController extends Controller
{
    public function store(AssignmentSubmissionStoreRequest $request): Response
    {
        $assignmentSubmission = AssignmentSubmission::create($request->validated());

        Notification::send($assignment->course->instructor, new AssignmentSubmittedNotification($assignmentSubmission));

        $request->session()->flash('assignmentSubmission.assignment.title', $assignmentSubmission->assignment->title);

        return redirect()->route('assignment.show', ['assignment' => $assignment]);
    }

    public function update(AssignmentSubmissionUpdateRequest $request, AssignmentSubmission $assignmentSubmission): Response
    {
        $assignmentSubmission = AssignmentSubmission::find($id);


        $assignmentSubmission->update($request->validated());

        Notification::send($assignmentSubmission->user, new AssignmentGradedNotification($assignmentSubmission));

        return redirect()->route('assignment.show', ['assignment' => $assignment]);
    }
}
