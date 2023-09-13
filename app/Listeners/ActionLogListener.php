<?php

namespace App\Listeners;

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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        /** @var User $user */
        $user = auth('api')->user();
        list($name, $description) = $event->getLog();

        (new ActionLog())->generate($user->id, $name, "用户 - [ {$user->username} ] | $description");
    }
}
