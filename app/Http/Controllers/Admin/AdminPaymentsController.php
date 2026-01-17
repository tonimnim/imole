<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminPaymentsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Payment::query()
            ->with(['user:id,name,email,avatar']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'ilike', "%{$search}%")
                            ->orWhere('email', 'ilike', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($payment) => [
                'id' => $payment->id,
                'reference' => $payment->reference,
                'user' => $payment->user ? [
                    'id' => $payment->user->id,
                    'name' => $payment->user->name,
                    'email' => $payment->user->email,
                    'avatar' => $payment->user->avatar ? asset('storage/'.$payment->user->avatar) : null,
                ] : null,
                'amount' => $payment->amount,
                'currency' => $payment->currency ?? 'KES',
                'status' => $payment->status,
                'payment_method' => $payment->payment_method,
                'created_at' => $payment->created_at->format('M d, Y H:i'),
            ]);

        $stats = [
            'total' => Payment::count(),
            'completed' => Payment::where('status', 'completed')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        return Inertia::render('Admin/Payments/Index', [
            'payments' => $payments,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
}
