<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;

class EnrollmentStoreRequest extends FormRequest
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

        // Check if user is not already enrolled in this course
        $courseId = $this->input('course_id');
        $alreadyEnrolled = Enrollment::query()
            ->where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->exists();

        return ! $alreadyEnrolled;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
        ];
    }
}
