<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
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

        // Get applied coupon from session
        $coupon = null;
        $discount = 0;
        $couponCode = session('coupon_code');

        if ($couponCode && $cartItems->isNotEmpty()) {
            $coupon = $this->getValidCoupon($couponCode, $cartItems);
            if ($coupon) {
                $discount = $this->calculateDiscount($coupon, $cartItems);
            } else {
                // Coupon no longer valid, clear it
                session()->forget('coupon_code');
            }
        }

        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);

        return view('cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'coupon' => $coupon,
            'couponCode' => $couponCode,
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
        session()->forget('coupon_code');

        return back()->with('success', 'Cart cleared successfully.');
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        $code = strtoupper(trim($validated['coupon_code']));

        // Get cart items
        $cartItems = Cart::query()
            ->where('user_id', auth()->id())
            ->with(['course.category'])
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Find and validate coupon
        $coupon = $this->getValidCoupon($code, $cartItems);

        if (! $coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }

        // Check per-user limit (simplified - would need a coupon_usages table for proper tracking)
        // For now, we'll skip this check

        // Store coupon in session
        session(['coupon_code' => $code]);

        $discount = $this->calculateDiscount($coupon, $cartItems);

        return back()->with('success', 'Coupon applied! You saved Ksh'.number_format($discount, 2));
    }

    public function removeCoupon(): RedirectResponse
    {
        session()->forget('coupon_code');

        return back()->with('success', 'Coupon removed.');
    }

    /**
     * Get a valid coupon if it exists and applies to cart items
     */
    protected function getValidCoupon(string $code, $cartItems): ?Coupon
    {
        $coupon = Coupon::where('code', strtoupper($code))
            ->where('is_active', true)
            ->first();

        if (! $coupon) {
            return null;
        }

        // Check validity dates
        $now = now();
        if ($coupon->valid_from && $now->lt($coupon->valid_from)) {
            return null;
        }
        if ($coupon->valid_until && $now->gt($coupon->valid_until)) {
            return null;
        }

        // Check if coupon applies to any cart item
        $applies = false;
        foreach ($cartItems as $item) {
            if ($this->couponAppliesToItem($coupon, $item)) {
                $applies = true;
                break;
            }
        }

        return $applies ? $coupon : null;
    }

    /**
     * Check if a coupon applies to a specific cart item
     */
    protected function couponAppliesToItem(Coupon $coupon, Cart $item): bool
    {
        // Course-specific coupon
        if ($coupon->course_id) {
            return $coupon->course_id === $item->course_id;
        }

        // Category-specific coupon
        if ($coupon->category_id) {
            return $coupon->category_id === $item->course->category_id;
        }

        // Global coupon (no course_id and no category_id)
        return true;
    }

    /**
     * Calculate the discount amount for applicable cart items
     */
    protected function calculateDiscount(Coupon $coupon, $cartItems): float
    {
        $totalDiscount = 0;

        foreach ($cartItems as $item) {
            if (! $this->couponAppliesToItem($coupon, $item)) {
                continue;
            }

            $itemPrice = $item->final_price;

            if ($coupon->discount_type === 'percentage') {
                $itemDiscount = $itemPrice * ($coupon->discount_value / 100);
            } else {
                // Fixed discount - apply to each applicable item
                $itemDiscount = min($coupon->discount_value, $itemPrice);
            }

            $totalDiscount += $itemDiscount;
        }

        // Apply max discount cap if set
        if ($coupon->max_discount && $totalDiscount > $coupon->max_discount) {
            $totalDiscount = $coupon->max_discount;
        }

        return round($totalDiscount, 2);
    }
}
