<?php

namespace App\Service\Install;

class BaseGameData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'game_name' => '王者',
                'parent_id' => null,
                'show' => 0,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'game_name' => '王者1v1',
                'parent_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'game_name' => '王者5v5',
                'parent_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'game_name' => '和平精英',
                'parent_id' => null,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }
}
