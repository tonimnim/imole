<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonProgressUpdateRequest;
use App\Jobs\UpdateCourseProgress;
use App\Models\LessonProgress;

class LessonProgressController extends Controller
{
    public function update(LessonProgressUpdateRequest $request, LessonProgress $lessonProgress)
    {
        $lessonProgress->update($request->validated());

        UpdateCourseProgress::dispatch($lessonProgress);

        return response()->json($lessonProgress, 200);
    }
}
