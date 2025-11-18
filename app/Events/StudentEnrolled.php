<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentEnrolled
{
    use Dispatchable, SerializesModels;

    public $enrollment;

    /**
     * Create a new event instance.
     */
    public function __construct($enrollment)
    {
        $this->enrollment = $enrollment;
    }
}
