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
    public function index(Request $request): View
    {
        $lessons = Lesson::query()->paginate(20);

        return view('lesson.index', [
            'lessons' => $lessons,
        ]);
    }

    public function show(Lesson $lesson): View
    {
        return view('lesson.show', [
            'lesson' => $lesson,
        ]);
    }

    public function store(LessonStoreRequest $request): RedirectResponse
    {
        $lesson = Lesson::create($request->validated());

        ProcessLessonVideo::dispatch($lesson);

        return redirect()->route('lesson.show', ['lesson' => $lesson]);
    }

    public function update(LessonUpdateRequest $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($request->validated());

        return redirect()->route('lesson.show', ['lesson' => $lesson]);
    }
}
