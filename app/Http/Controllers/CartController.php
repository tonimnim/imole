<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::query()
            ->where('user_id', auth()->id())
            ->with(['course' => function ($query) {
                $query->with(['instructor', 'category']);
            }])
            ->get();

        $subtotal = $cartItems->sum('final_price');
        $tax = 0; // Add tax calculation if needed
        $total = $subtotal + $tax;

        return view('cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'buy_now' => ['sometimes', 'boolean'],
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Check if user is already enrolled
        if ($course->enrollments()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        // Check if course is free
        if ($course->price <= 0) {
            return back()->with('error', 'Free courses cannot be added to cart. Enroll directly.');
        }

        // Add or update cart item
        Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'course_id' => $course->id,
            ],
            [
                'price' => $course->price,
                'discount_price' => $course->discount_price,
            ]
        );

        // If buy_now is true, redirect to checkout
        if ($request->boolean('buy_now')) {
            return redirect()
                ->route('checkout.index')
                ->with('success', 'Proceed to complete your purchase!');
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Course added to cart!');
    }

    public function remove(Cart $cart): RedirectResponse
    {
        // Authorization check
        abort_unless($cart->user_id === auth()->id(), 403);

        $cart->delete();

        return back()->with('success', 'Course removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        Cart::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Cart cleared successfully.');
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        // TODO: Implement coupon validation and application logic
        // For now, just return an error
        return back()->with('error', 'Invalid coupon code.');
    }
}
