<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Jobs\UpdateCourseRating;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request): Response
    {
        $review = Review::create($request->validated());

        UpdateCourseRating::dispatch($review);

        return redirect()->route('course.show', ['course' => $course]);
    }
}
