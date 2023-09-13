<?php

namespace App\Listeners;

use App\Models\Admin\AdminLogs;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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

        (new AdminLogs())->generate($user->id, $name, "用户 - [ {$user->username} ] | $description");
    }
}
