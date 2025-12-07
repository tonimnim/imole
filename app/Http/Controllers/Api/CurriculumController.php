<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurriculumController extends Controller
{
    /**
     * Get the full curriculum for a course.
     */
    public function index(Course $course): JsonResponse
    {
        $this->authorizeCourse($course);

        $modules = $course->modules()
            ->with(['lessons' => fn ($q) => $q->orderBy('order')])
            ->orderBy('order')
            ->get();

        return response()->json([
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
            ],
            'modules' => $modules,
        ]);
    }

    /**
     * Store a new module.
     */
    public function storeModule(Request $request, Course $course): JsonResponse
    {
        $this->authorizeCourse($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = $course->modules()->max('order') ?? 0;

        $module = $course->modules()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $maxOrder + 1,
            'is_published' => false,
        ]);

        return response()->json($module->load('lessons'), 201);
    }

    /**
     * Update a module.
     */
    public function updateModule(Request $request, Module $module): JsonResponse
    {
        $this->authorizeModule($module);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $module->update($validated);

        return response()->json($module);
    }

    /**
     * Delete a module and its lessons.
     */
    public function destroyModule(Module $module): JsonResponse
    {
        $this->authorizeModule($module);

        $module->lessons()->delete();
        $module->delete();

        return response()->json(['message' => 'Module deleted']);
    }

    /**
     * Store a new lesson.
     */
    public function storeLesson(Request $request, Module $module): JsonResponse
    {
        $this->authorizeModule($module);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,text,quiz,assignment',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string',
            'is_free' => 'sometimes|boolean',
        ]);

        $maxOrder = $module->lessons()->max('order') ?? 0;

        $lesson = $module->lessons()->create([
            'course_id' => $module->course_id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(6),
            'type' => $validated['type'],
            'content' => $validated['content'] ?? '',
            'video_url' => $validated['video_url'] ?? '',
            'video_provider' => $this->detectVideoProvider($validated['video_url'] ?? null),
            'order' => $maxOrder + 1,
            'is_free' => $validated['is_free'] ?? false,
            'is_published' => false,
        ]);

        return response()->json($lesson, 201);
    }

    /**
     * Update a lesson.
     */
    public function updateLesson(Request $request, Lesson $lesson): JsonResponse
    {
        $this->authorizeLesson($lesson);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:video,text,quiz,assignment',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string',
            'is_free' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
        ]);

        if (isset($validated['video_url'])) {
            $validated['video_provider'] = $this->detectVideoProvider($validated['video_url']);
        }

        $lesson->update($validated);

        return response()->json($lesson);
    }

    /**
     * Delete a lesson.
     */
    public function destroyLesson(Lesson $lesson): JsonResponse
    {
        $this->authorizeLesson($lesson);

        $lesson->delete();

        return response()->json(['message' => 'Lesson deleted']);
    }

    /**
     * Reorder modules and lessons.
     */
    public function reorder(Request $request, Course $course): JsonResponse
    {
        $this->authorizeCourse($course);

        $validated = $request->validate([
            'modules' => 'required|array',
            'modules.*.id' => 'required|integer|exists:modules,id',
            'modules.*.order' => 'required|integer',
            'modules.*.lessons' => 'sometimes|array',
            'modules.*.lessons.*.id' => 'required|integer|exists:lessons,id',
            'modules.*.lessons.*.order' => 'required|integer',
        ]);

        foreach ($validated['modules'] as $moduleData) {
            Module::where('id', $moduleData['id'])
                ->where('course_id', $course->id)
                ->update(['order' => $moduleData['order']]);

            if (isset($moduleData['lessons'])) {
                foreach ($moduleData['lessons'] as $lessonData) {
                    Lesson::where('id', $lessonData['id'])
                        ->where('module_id', $moduleData['id'])
                        ->update([
                            'order' => $lessonData['order'],
                            'module_id' => $moduleData['id'],
                        ]);
                }
            }
        }

        return response()->json(['message' => 'Order updated']);
    }

    /**
     * Detect video provider from URL.
     */
    private function detectVideoProvider(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'youtube';
        }

        if (str_contains($url, 'vimeo.com')) {
            return 'vimeo';
        }

        return 'other';
    }

    /**
     * Authorize that the current user owns the course.
     */
    private function authorizeCourse(Course $course): void
    {
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Authorize that the current user owns the module's course.
     */
    private function authorizeModule(Module $module): void
    {
        $this->authorizeCourse($module->course);
    }

    /**
     * Authorize that the current user owns the lesson's course.
     */
    private function authorizeLesson(Lesson $lesson): void
    {
        $this->authorizeCourse($lesson->course);
    }
}
