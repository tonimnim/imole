<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentStoreRequest;
use App\Models\Assignment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function show(Assignment $assignment): View
    {
        return view('assignment.show', [
            'assignment' => $assignment,
        ]);
    }

    public function store(AssignmentStoreRequest $request): RedirectResponse
    {
        $assignment = Assignment::create($request->validated());

        return redirect()->route('assignment.show', ['assignment' => $assignment]);
    }
}
