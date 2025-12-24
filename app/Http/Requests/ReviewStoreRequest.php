<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // User must be authenticated
        if (! auth()->check()) {
            return false;
        }

        $courseId = $this->input('course_id');

        // Must be enrolled in the course
        $isEnrolled = Enrollment::query()
            ->where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->exists();

        if (! $isEnrolled) {
            return false;
        }

        // Cannot review the same course twice
        $hasReviewed = Review::query()
            ->where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->exists();

        return ! $hasReviewed;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
