<?php

namespace App\Service\Install;

class BaseWithdrawalAmountConfigData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'title' => '20元',
                'amount' => 2000,
                'vip_amount' => 2000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '100元',
                'amount' => 10000,
                'vip_amount' => 10000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '200元',
                'amount' => 20000,
                'vip_amount' => 20000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '500元',
                'amount' => 50000,
                'vip_amount' => 50000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '800元',
                'amount' => 80000,
                'vip_amount' => 80000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'title' => '1000元',
                'amount' => 100000,
                'vip_amount' => 100000,
                'unit_id' => 1,
                'show' => 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }
}
