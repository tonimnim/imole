<?php

namespace App\Http\Controllers;

use App\Events\QuizAttemptStarted;
use App\Http\Requests\QuizAttemptStoreRequest;
use App\Http\Requests\QuizAttemptUpdateRequest;
use App\Jobs\GradeQuizAttempt;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function store(QuizAttemptStoreRequest $request): Response
    {
        $quizAttempt = QuizAttempt::create($request->validated());

        QuizAttemptStarted::dispatch($quizAttempt);

        return redirect()->route('quizAttempt.show', ['quizAttempt' => $quizAttempt]);
    }

    public function update(QuizAttemptUpdateRequest $request, QuizAttempt $quizAttempt): Response
    {
        $quizAttempt = QuizAttempt::find($id);


        $quizAttempt->update($request->validated());

        GradeQuizAttempt::dispatch($quizAttempt);

        return redirect()->route('quizAttempt.show', ['quizAttempt' => $quizAttempt]);
    }
}
