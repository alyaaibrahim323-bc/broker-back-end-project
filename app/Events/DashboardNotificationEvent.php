<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DashboardNotificationEvent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('dashboard-notifications'); // قناة البث للإشعارات
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
