<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $name;
    protected $description;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $description)
    {
        //
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return array
     */
    public function getLog()
    {
        return [
            $this->name,
            $this->description
        ];
    }

    /**
     * @param $name
     * @param $description
     * @return $this
     */
    public static function saveEvent($name, $description)
    {
        $name = "保存 - $name";
        return self::generate($name, "$name - [$description]");
    }

    /**
     * @param $name
     * @param $description
     * @return $this
     */
    public static function deleteEvent($name, $description)
    {
        $name = "删除 - $name";
        return self::generate($name, "$name - [$description]");
    }

    /**
     * @param $name
     * @param $description
     * @return $this
     */
    public static function generate($name, $description)
    {
        return new ActionLogEvent($name, $description);
    }
}
