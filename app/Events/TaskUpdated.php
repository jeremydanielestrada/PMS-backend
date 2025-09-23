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

class TaskUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task->load(['assignedUser', 'project']);
    }

    public function broadcastOn()
    {
        return new Channel('project.' . $this->task->project_id);
    }

    public function broadcastWith()
    {
        return [
            'task' => $this->task,
            'message' => 'Task updated'
        ];
    }
}
