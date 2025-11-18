<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GradeQuizAttempt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $quizAttempt;

    /**
     * Create a new job instance.
     */
    public function __construct($quizAttempt)
    {
        $this->quizAttempt = $quizAttempt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
