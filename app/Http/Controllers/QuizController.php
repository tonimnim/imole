<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizStoreRequest;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function show(Quiz $quiz): View
    {
        return view('quiz.show', [
            'quiz' => $quiz,
        ]);
    }

    public function store(QuizStoreRequest $request): RedirectResponse
    {
        $quiz = Quiz::create($request->validated());

        return redirect()->route('quiz.show', ['quiz' => $quiz]);
    }
}
