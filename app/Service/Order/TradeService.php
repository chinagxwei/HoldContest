<?php

namespace App\Service\Order;

use App\Models\Goods\Goods;
use App\Models\Member\Member;
use App\Models\Order\Order;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletWithdrawal;
use App\Service\Vip\VipService;
use App\Service\Wallet\PaymentService;
use App\Service\Wallet\RechargeService;
use App\Service\Wallet\RefundService;

class TradeService
{
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

    /**
     * @param $member_id
     * @param $wallet_id
     * @param $price
     * @param $unit_id
     * @return string
     * @throws \Exception
     */
    public static function withdraw($member_id, $wallet_id, $price, $unit_id)
    {

        $order = Order::getWithdrawalOrder($member_id, $price, $unit_id);

        $order->complete()->save();

        $payment = new PaymentService();

       $wallet =  Wallet::findOneByID($wallet_id);

        $payment->setOrder($order)->setWallet($wallet)->execute();

        return $order->sn;
    }

    /**
     * @param $withdraw_id
     * @return bool
     * @throws \Exception
     */
    public static function withdrawCancel($withdraw_id){
        $withdraw = WalletWithdrawal::findOneByID($withdraw_id,['order']);

        (new RefundService())->setOrder($withdraw->order)->execute();

        return $withdraw->cancel()->save();
    }
}
