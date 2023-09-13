<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class QueryListener
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
        //
        if ($event->sql && config('app.debug')) {
            // 把sql  的日志独立分开
            $fileName = storage_path('logs\\' . date('Y-m-d') . '_sql.log');

            // Insert bindings into query
            $query = str_replace(['%', '?'], ['%%', '%s'], $event->sql);

            $query = vsprintf($query, $event->bindings);

            // Save the query to file
            try {
                $logFile = fopen($fileName, 'a+');
                fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL . "\r\n");
                fclose($logFile);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
