<?php

namespace App\Service\Install;

class BaseRechargeData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'title' => '10元',
                'denomination' => 1000,
                'give_amount' => 200,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '20元',
                'denomination' => 2000,
                'give_amount' => 450,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '50元',
                'denomination' => 5000,
                'give_amount' => 1100,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '100元',
                'denomination' => 10000,
                'give_amount' => 2000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '200元',
                'denomination' => 20000,
                'give_amount' => 4500,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '500元',
                'denomination' => 50000,
                'give_amount' => 11000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '1000元',
                'denomination' => 100000,
                'give_amount' => 230000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }
}
