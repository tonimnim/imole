<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Jobs\ProcessLessonVideo;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Request $request): Response
    {
        $lessons = Lesson::all();

        return view('lesson.index', [
            'lessons' => $lessons,
        ]);
    }

    public function show(Request $request, Lesson $lesson): Response
    {
        $lesson = Lesson::find($id);

        return view('lesson.show', [
            'lesson' => $lesson,
        ]);
    }

    public function store(LessonStoreRequest $request): Response
    {
        $lesson = Lesson::create($request->validated());

        ProcessLessonVideo::dispatch($lesson);

        return redirect()->route('lesson.show', ['lesson' => $lesson]);
    }

    public function update(LessonUpdateRequest $request, Lesson $lesson): Response
    {
        $lesson = Lesson::find($id);


        $lesson->update($request->validated());

        return redirect()->route('lesson.show', ['lesson' => $lesson]);
    }
}
