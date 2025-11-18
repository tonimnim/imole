<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonProgressUpdateRequest;
use App\Jobs\UpdateCourseProgress;
use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function update(LessonProgressUpdateRequest $request, LessonProgress $lessonProgress): Response
    {
        $lessonProgress = LessonProgress::find($id);


        $lessonProgress->update($request->validated());

        UpdateCourseProgress::dispatch($lessonProgress);

        return $lessonProgress, 200;
    }
}
