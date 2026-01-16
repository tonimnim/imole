<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function programs()
    {
        return view('pages.programs');
    }

    public function impact()
    {
        return view('pages.impact');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Send email or store in database
        // For now, just redirect with success message
        
        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function cookies()
    {
        return view('pages.cookies');
    }

    public function accessibility()
    {
        return view('pages.accessibility');
    }
}
