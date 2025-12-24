<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentStoreRequest;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function show(Request $request, Assignment $assignment): Response
    {
        $assignment = Assignment::find($id);

        return view('assignment.show', [
            'assignment' => $assignment,
        ]);
    }

    public function store(AssignmentStoreRequest $request): Response
    {
        $assignment = Assignment::create($request->validated());

        return redirect()->route('assignment.show', ['assignment' => $assignment]);
    }
}
