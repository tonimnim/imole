<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonProgressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'is_completed' => ['required'],
            'time_spent_seconds' => ['required', 'integer'],
        ];
    }
}
