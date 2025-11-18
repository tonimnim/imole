<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Jobs\ProcessCourseThumbnail;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = Course::all();

        return view('course.index', [
            'courses' => $courses,
        ]);
    }

    public function show(Request $request, Course $course): Response
    {
        $course = Course::find($id);

        return view('course.show', [
            'course' => $course,
        ]);
    }

    public function store(CourseStoreRequest $request): Response
    {
        $course = Course::create($request->validated());

        ProcessCourseThumbnail::dispatch($course);

        $request->session()->flash('course.title', $course->title);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function update(CourseUpdateRequest $request, Course $course): Response
    {
        $course = Course::find($id);


        $course->update($request->validated());

        $request->session()->flash('course.title', $course->title);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function destroy(Request $request, Course $course): Response
    {
        $course = Course::find($id);

        $course->delete();

        return redirect()->route('course.index');
    }
}
