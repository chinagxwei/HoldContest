<?php

namespace App\Service\Install;

class BaseVIPData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'title' => '7天VIP',
                'day' => 7,
                'show' => 0,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '15天VIP',
                'day' => 15,
                'show' => 0,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '30天VIP',
                'day' => 30,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '90天VIP',
                'day' => 90,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '365天VIP',
                'day' => 365,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ]
        ];
    }
}
