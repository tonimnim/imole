<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistStoreRequest;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(WishlistStoreRequest $request): Response
    {
        $wishlist = Wishlist::create($request->validated());

        $request->session()->flash('wishlist.course.title', $wishlist->course->title);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function destroy(Request $request, Wishlist $wishlist): Response
    {
        $wishlist = Wishlist::find($id);

        $wishlist->delete();

        return redirect()->route('wishlist.index');
    }
}
