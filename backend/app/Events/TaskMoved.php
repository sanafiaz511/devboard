<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskMoved implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Task $task
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('kanban'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'task.moved';
    }
}
