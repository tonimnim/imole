<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizStoreRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Request $request, Quiz $quiz): Response
    {
        $quiz = Quiz::find($id);

        return view('quiz.show', [
            'quiz' => $quiz,
        ]);
    }

    public function store(QuizStoreRequest $request): Response
    {
        $quiz = Quiz::create($request->validated());

        return redirect()->route('quiz.show', ['quiz' => $quiz]);
    }
}
