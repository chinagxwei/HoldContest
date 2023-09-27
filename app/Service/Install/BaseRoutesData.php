<?php

namespace App\Service\Install;

class BaseRoutesData
{

    public static function getSystemData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '协议管理',
                'navigation_link' => './system/agreement',
                'navigation_router' => 'platform/system/agreement',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '投诉管理',
                'navigation_link' => './system/complaint',
                'navigation_router' => 'platform/system/complaint',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '图片管理',
                'navigation_link' => './system/images',
                'navigation_router' => 'platform/system/images',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '标签管理',
                'navigation_link' => './system/target',
                'navigation_router' => 'platform/system/target',
                'navigation_sort' => 4,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '单位管理',
                'navigation_link' => './system/unit',
                'navigation_router' => 'platform/system/unit',
                'navigation_sort' => 5,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '系统配置管理',
                'navigation_link' => './system/system-config',
                'navigation_router' => 'platform/system/system-config',
                'navigation_sort' => 6,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '导航管理',
                'navigation_link' => './system/navigation',
                'navigation_router' => 'platform/system/navigation',
                'navigation_sort' => 7,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '用户角色管理',
                'navigation_link' => './system/role',
                'navigation_router' => 'platform/system/role',
                'navigation_sort' => 8,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '用户管理',
                'navigation_link' => './system/manager',
                'navigation_router' => 'platform/system/manager',
                'navigation_sort' => 9,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '管理员日志',
                'navigation_link' => './system/action-log',
                'navigation_router' => 'platform/system/action-log',
                'navigation_sort' => 10,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => 'app错误日志管理',
                'navigation_link' => './system/app-bug-log',
                'navigation_router' => 'platform/system/app-bug-log',
                'navigation_sort' => 11,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => 'app发布管理',
                'navigation_link' => './system/app-publish-log',
                'navigation_router' => 'platform/system/app-publish-log',
                'navigation_sort' => 12,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getCompetitionData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '比赛游戏管理',
                'navigation_link' => './system/competition-game',
                'navigation_router' => 'platform/system/competition-game',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '游戏房间管理',
                'navigation_link' => './system/competition-room',
                'navigation_router' => 'platform/system/competition-room',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '游戏团队管理',
                'navigation_link' => './system/competition-game-team',
                'navigation_router' => 'platform/system/competition-game-team',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getGoodsData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '商品列表',
                'navigation_link' => './system/goods',
                'navigation_router' => 'platform/system/goods',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '充值产品',
                'navigation_link' => './system/product-recharge',
                'navigation_router' => 'platform/system/product-recharge',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => 'VIP产品',
                'navigation_link' => './system/product-vip',
                'navigation_router' => 'platform/system/product-vip',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getActivityData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '任务管理',
                'navigation_link' => './system/quest',
                'navigation_router' => 'platform/system/quest',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '抽奖项管理',
                'navigation_link' => './system/lucky-draws-item',
                'navigation_router' => 'platform/system/lucky-draws-item',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '抽奖配置管理',
                'navigation_link' => './system/lucky-draws-config',
                'navigation_router' => 'platform/system/lucky-draws-config',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getMemberData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '会员管理',
                'navigation_link' => './system/member',
                'navigation_router' => 'platform/system/member',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '会员地址管理',
                'navigation_link' => './system/member-address',
                'navigation_router' => 'platform/system/member-address',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '会员禁封管理',
                'navigation_link' => './system/member-ban-log',
                'navigation_router' => 'platform/system/member-ban-log',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '会员消息管理',
                'navigation_link' => './system/member-message',
                'navigation_router' => 'platform/system/member-message',
                'navigation_sort' => 4,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '会员奖励记录管理',
                'navigation_link' => './system/member-prize-log',
                'navigation_router' => 'platform/system/member-prize-log',
                'navigation_sort' => 5,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '称号管理',
                'navigation_link' => './system/title',
                'navigation_router' => 'platform/system/title',
                'navigation_sort' => 6,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getOrderData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '订单管理',
                'navigation_link' => './system/order',
                'navigation_router' => 'platform/system/order',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '订单收益管理',
                'navigation_link' => './system/order-income',
                'navigation_router' => 'platform/system/order-income',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '订单收益配置管理',
                'navigation_link' => './system/order-income-config',
                'navigation_router' => 'platform/system/order-income-config',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getWalletData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包管理',
                'navigation_link' => './system/wallet',
                'navigation_router' => 'platform/system/wallet',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],

            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包充值管理',
                'navigation_link' => './system/wallet-recharge',
                'navigation_router' => 'platform/system/wallet-recharge',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包提现管理',
                'navigation_link' => './system/wallet-withdrawal',
                'navigation_router' => 'platform/system/wallet-withdrawal',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包提现账户管理',
                'navigation_link' => './system/wallet-withdrawal-account',
                'navigation_router' => 'platform/system/wallet-withdrawal-account',
                'navigation_sort' => 4,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包消费管理',
                'navigation_link' => './system/wallet-consume',
                'navigation_router' => 'platform/system/wallet-consume',
                'navigation_sort' => 5,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '钱包日志管理',
                'navigation_link' => './system/wallet-log',
                'navigation_router' => 'platform/system/wallet-log',
                'navigation_sort' => 6,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }

    public static function getWechatData($menus_id, $created_by)
    {
        $time = time();
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '微信小程序会员管理',
                'navigation_link' => './system/wechat-mini-program',
                'navigation_router' => 'platform/system/wechat-mini-program',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '微信公众号会员管理',
                'navigation_link' => './system/wechat-office-account',
                'navigation_router' => 'platform/system/wechat-office-account',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ]
        ];
    }
}
