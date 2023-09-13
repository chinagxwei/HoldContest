<?php

namespace App\Service\Install;

class BaseUnitData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'title' => '现金',
                'description' => '现金',
                'label' => '现金',
                'symbol' => '',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
//            [
//                'title' => '金币',
//                'description' => '金币',
//                'label' => '金币',
//                'symbol' => '',
//                'created_by' => $created_by,
//                'created_at' => $time,
//                'updated_at' => $time
//            ],
//            [
//                'title' => '积分',
//                'description' => '积分',
//                'label' => '积分',
//                'symbol' => '',
//                'created_by' => $created_by,
//                'created_at' => $time,
//                'updated_at' => $time
//            ],
        ];
    }
}
