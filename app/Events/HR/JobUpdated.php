<?php

namespace App\Events\HR;

use App\Models\HR\Job;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $job;
    public $attr;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, $attr = [])
    {
        $this->job = $job;
        $this->attr = $attr;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return void
     */
    public function broadcastOn()
    {
        //
    }
}
