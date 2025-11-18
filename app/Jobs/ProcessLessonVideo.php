<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLessonVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lesson;

    /**
     * Create a new job instance.
     */
    public function __construct($lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
