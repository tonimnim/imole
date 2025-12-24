<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Jobs\UpdateCourseRating;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $review = Review::create($validated);

        UpdateCourseRating::dispatch($review);

        return redirect()
            ->route('courses.show', ['course' => $review->course])
            ->with('success', 'Review submitted for approval.');
    }

    public function markHelpful(Request $request, Review $review): RedirectResponse
    {
        $sessionKey = "review_helpful_{$review->id}";

        if (! session()->has($sessionKey)) {
            $review->increment('helpful_count');
            session()->put($sessionKey, true);

            return back()->with('success', 'Thank you for your feedback!');
        }

        return back()->with('info', 'You already marked this as helpful.');
    }
}
