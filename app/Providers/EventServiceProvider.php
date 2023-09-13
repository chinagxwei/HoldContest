<?php

namespace App\Providers;

use App\Events\ActionLogEvent;
use App\Listeners\ActionLogListener;
use App\Listeners\QueryListener;
use App\Models\ActionLog;
use App\Models\Admin\AdminMessage;
use App\Models\Admin\AdminNavigation;
use App\Models\Admin\AdminRole;
use App\Models\Member\Member;
use App\Models\Order\Order;
use App\Models\System\SystemAgreement;
use App\Models\System\SystemComplaint;
use App\Models\System\SystemConfig;
use App\Models\System\SystemImage;
use App\Models\Wallet\Wallet;
use App\Observers\ActionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        QueryExecuted::class => [
            QueryListener::class
        ],
        ActionLogEvent::class => [
            ActionLogListener::class
        ],
    ];

    protected $creates = [
        AdminRole::class,
        AdminNavigation::class,
        AdminMessage::class,
        SystemAgreement::class,
        SystemComplaint::class,
        SystemConfig::class,
        SystemImage::class,
        ActionLog::class,
        Member::class,
        Order::class,
        Wallet::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        foreach ($this->creates as $model) {
            $model::observe(ActionObserver::class);
        }
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
