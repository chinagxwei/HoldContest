<?php

namespace App\Listeners;

use App\Events\ActionLogEvent;
use App\Models\ActionLog;
use App\Models\User;

class ActionLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ActionLogEvent $event
     * @return void
     */
    public function handle($event)
    {
        /** @var User $user */
        $user = auth('api')->user();
        list($name, $description) = $event->getLog();
        $ip = "0.0.0.0";
        if ($request = request()) {
            $ip = $request->ip();
        }
        (new ActionLog())->generate($user->id, $name, "用户 - [ {$user->username} ] | $description", $ip);
    }
}
