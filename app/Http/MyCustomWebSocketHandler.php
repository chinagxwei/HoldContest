<?php

namespace App\Http;

use App\Service\Utils\ImService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use function AlibabaCloud\Client\json;

class MyCustomWebSocketHandler implements MessageComponentInterface
{

    function onOpen(ConnectionInterface $conn)
    {
        // TODO: Implement onOpen() method.
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));

        $conn->socketId = $socketId;

        $conn->app = new  \stdClass();

        $conn->app->id = env('APP_NAME') . '- sms';

        return $conn->send("[" . now()->toDateString() . "] connect IM Server");

    }

    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        // TODO: Implement onMessage() method.
        Log::info($msg);

        if (((trim($msg) === 'ping') || trim($msg) === 'PING')) {
            $conn->send('pong');
        } else {
            try {
                $event_data = ImService::handleMessage($msg->getPayload());
                if ($session = ImService::getSession($event_data['token'])) {
                    switch ($event_data['event']) {
                        case ImService::EVENT_GET_ROOM_DATA:
                            $room = Cache::get("join_room_{$session['member_id']}");
                            if (!empty($room)) {
                                $format_room = json_decode($room, true);

                                if ($format_room['join_number'] >= $format_room['start_number']) {
                                    if (!empty($format_room['quick'])) {
                                        $format_room['is_start'] = 1;
                                    } else if ($format_room['started_at'] >= time()) {
                                        $format_room['is_start'] = 1;
                                    } else {
                                        $format_room['is_start'] = 0;
                                    }
                                } else {
                                    $format_room['is_start'] = 0;
                                }

                                if (empty($format_room['is_start'])) {
                                    unset($format_room['room_id']);
                                    unset($format_room['room_name']);
                                    unset($format_room['link']);
                                }
                                $conn->send(json_encode($format_room));
                            }
                            break;
                    }
                } else {
                    $conn->close();
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
