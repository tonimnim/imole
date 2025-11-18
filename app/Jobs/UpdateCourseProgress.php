<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCourseProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lessonProgress;

    /**
     * Create a new job instance.
     */
    public function __construct($lessonProgress)
    {
        $this->lessonProgress = $lessonProgress;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
