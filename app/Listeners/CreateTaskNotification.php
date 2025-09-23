<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class CreateTaskNotification
{
    public function handle(TaskUpdated $event)
    {
        // Create notification for assigned user if task is assigned to someone
        if ($event->task->assigned_to) {
            Notification::create([
                'user_id' => $event->task->assigned_to,
                'type' => 'task_updated',
                'is_read' => false
            ]);
        }
    }
}
