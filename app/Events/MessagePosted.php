<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\User;
use App\Entities\PrivateMessage;
class MessagePosted  implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public $user;
     public $message;
    public function __construct(User $user, PrivateMessage $message)
    {
        //
        $this->user=$user;
        $this->message=$message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
 
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return new PrivateChannel('chat_lists.'.$this->message->channel_id);
        
    }
    public function broadcastAs()
        {
            return 'event';
        }
}
