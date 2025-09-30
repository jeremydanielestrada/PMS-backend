<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskAssigned implements ShouldBroadcast
{
    use Dispatchable,  SerializesModels,InteractsWithSockets;

    public $task;
    public function __construct(Task $task)
    {
        $this->task = $task->load(['assignedUser', 'project']);
    }


    public function broadcastOn(): Channel
    {
        return new Channel('project.' . $this->task->assigned_to);
    }



     public function broadcastWith()
    {
        return [
            'task' => $this->task,
            'message' => 'You are assigned to a task'
        ];
    }
}
