<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizAttemptStarted
{
    use Dispatchable, SerializesModels;

    public $quizAttempt;

    /**
     * Create a new event instance.
     */
    public function __construct($quizAttempt)
    {
        $this->quizAttempt = $quizAttempt;
    }
}
