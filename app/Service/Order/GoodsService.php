<?php

namespace App\Service\Order;

use App\Models\Goods\Goods;
use App\Service\Vip\VipService;
use App\Service\Wallet\RechargeService;

class GoodsService
{
    /**
     * @throws \Exception
     */
    public static function exchange($goods_id, $member_id)
    {
        $goods = Goods::findOneByID($goods_id, ['vip', 'recharge']);

        if ($goods && $goods->isRelationType() && ($goods->isVipCategory() || $goods->isRechargeCardCategory())) {
            if ($goods->isRechargeCardCategory()) {
                return RechargeService::exchangeRechargeCard($goods->relation_id, $member_id);
            } elseif ($goods->isVipCategory()) {
                return VipService::platformCustom($goods->relation_id, $member_id);
            } else {
                throw new \Exception('兑换商品品种错误');
            }
        }

        throw new \Exception('兑换商品类型错误');
    }
}
