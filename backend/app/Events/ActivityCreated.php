<?php

namespace App\Events;

use App\Models\Activity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public Activity $activity) {}

    public function broadcastOn(): array
    {
        return [new Channel('activity')];
    }

    public function broadcastAs(): string
    {
        return 'activity.created';
    }
}
