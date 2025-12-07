<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class QuizBuilderPageController extends Controller
{
    public function index(): View
    {
        return view('teacher.quiz-builder');
    }
}
