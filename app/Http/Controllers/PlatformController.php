<?php

namespace App\Http\Controllers;

use App\Events\ActionLogEvent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Event;

abstract class PlatformController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $controller_event_text = self::class;

    /**
     * @param $code
     * @param $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function toJsonResponse($code, $message, $data)
    {
        $result = [
            'code' => $code,
            'message' => $message
        ];

        if (!empty($data)) {
            $result['data'] = $data;
        }

        return response()->json($result);
    }

    /**
     * @param $data
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successJsonResponse($data = null, $message = 'success')
    {
        return self::toJsonResponse(200, $message, $data);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failJsonResponse($message = 'fail')
    {
        return self::toJsonResponse(500, $message, null);
    }

    /**
     * @param $description
     * @return void
     */
    public function saveEvent($description)
    {
        Event::dispatch(ActionLogEvent::saveEvent($this->controller_event_text, $description));
    }

    /**
     * @param $description
     * @return void
     */
    public function deleteEvent($description)
    {
        Event::dispatch(ActionLogEvent::deleteEvent($this->controller_event_text, $description));
    }

    /**
     * @param $name
     * @param $description
     * @return void
     */
    public function generateEvent($name, $description)
    {
        Event::dispatch(ActionLogEvent::generate($name, $description));
    }
}
