<?php

namespace App\Service\Install;

class BaseIncomeConfigData
{
    public static function getData($created_by, $time)
    {
        return [
            [
                'title' => '默认系统收益',
                'vip_commission' => 0,
                'recharge_commission' => 0,
                'consume_commission' => 0,
                'level_1_play_commission' => 0,
                'level_2_play_commission' => 0,
                'agent_commission' => 0,
                'withdraw_point' => 0.06,
                'vip_withdraw_point' => 0.03,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ]
        ];
    }
}
