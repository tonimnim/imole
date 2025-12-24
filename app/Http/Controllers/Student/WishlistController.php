<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistStoreRequest;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlists = Wishlist::query()
            ->where('user_id', auth()->id())
            ->with(['course' => function ($query) {
                $query->with(['instructor', 'category'])
                    ->withCount(['enrollments', 'reviews', 'lessons'])
                    ->withAvg('reviews', 'rating');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('student.wishlist', [
            'wishlists' => $wishlists,
        ]);
    }

    public function store(WishlistStoreRequest $request): RedirectResponse
    {
        $wishlist = Wishlist::create([
            'user_id' => auth()->id(),
            'course_id' => $request->validated()['course_id'],
        ]);

        $request->session()->flash('wishlist.course.title', $wishlist->course->title);

        return redirect()->route('courses.show', ['course' => $wishlist->course]);
    }

    public function destroy(Wishlist $wishlist): RedirectResponse
    {
        $wishlist->delete();

        return redirect()->route('student.wishlist');
    }
}
