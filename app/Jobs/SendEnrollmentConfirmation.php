<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEnrollmentConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $enrollment;

    /**
     * Create a new job instance.
     */
    public function __construct($enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
