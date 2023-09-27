<?php

namespace App\Service\Utils;

use Illuminate\Support\Facades\Cache;

class ImService
{

    const EVENT_GET_ROOM_DATA = 10001;

    const EVENTS = [
        self::EVENT_GET_ROOM_DATA,
    ];

    public static function setMemberSession($member_id, $created_by)
    {
        $key = self::getMemberToken($member_id, $created_by);

        Cache::add($key, ['member_id' => $member_id, 'created_by' => $created_by]);

        return $key;
    }

    public static function setAdminSession($created_by)
    {
        $key = self::getAdminToken($created_by);

        Cache::add($key, ['created_by' => $created_by]);

        return $key;
    }

    /**
     * @param $token
     * @return null|mixed
     */
    public static function getSession($token)
    {

        $session = Cache::get($token);

        if (empty($session)) {
            return null;
        } else {
            return $session;
        }
    }

    /**
     * @param $member_id
     * @param $created_by
     * @return string
     */
    public static function getMemberToken($member_id, $created_by)
    {
        return md5("{$member_id}_{$created_by}");
    }

    /**
     * @param $created_by
     * @return string
     */
    public static function getAdminToken($created_by)
    {
        return md5("admin_{$created_by}");
    }

    public static function logout($token)
    {
        Cache::forget($token);
    }

    /**
     * 消息格式：token,event,data
     *
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public static function handleMessage($message)
    {
        if (!is_string($message)) {
            throw new \Exception('消息格式错误');
        }

        $decode_message = json_decode($message, true);

        if (empty($decode_message['token']) || empty($decode_message['event'])) {
            throw new \Exception('参数错误');
        }

        if (!in_array($decode_message['event'], self::EVENTS)) {
            throw new \Exception('事件错误');
        }

        return $decode_message;
    }
}
