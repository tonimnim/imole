<?php

namespace App\Http\Controllers;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }
}
