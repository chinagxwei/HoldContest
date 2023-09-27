<?php

namespace App\Service\Wallet;

use App\Models\BaseDataModel;
use App\Models\Goods\ProductRecharge;
use App\Models\Member\Member;
use App\Models\Order\Order;
use App\Models\Wallet\WalletLog;
use App\Models\Wallet\WalletRecharge;
use App\Models\Wallet\WalletUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RechargeService
{
    /**
     * 平台自定义充值
     * 创建订单-》生成充值记录-》生成钱包流水
     *
     * @param $member_id
     * @param $total_amount
     * @param $pay_amount
     * @param $unit_id
     * @param string $remark
     * @return string|bool
     * @throws \Exception
     */
    public static function platformCustom($member_id, $total_amount, $pay_amount, $unit_id, $remark = '')
    {
        DB::beginTransaction();

        try {
            $order = Order::getRechargeOrder($member_id, $total_amount * 100, $pay_amount * 100, $unit_id, $remark);

            $order->complete()->save();

            $member = Member::findOneByID($member_id, ['wallet']);

            WalletRecharge::generate($member->wallet_id, $order->sn, $total_amount * 100, $unit_id, BaseDataModel::DISABLE, WalletRecharge::CHANNEL_PLATFORM);

            $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $unit_id);

            if (WalletUnit::hasRow($member->wallet_id, $unit_id)) {
                $member->wallet->setTotalBalanceByUnit($unit_id, $total_balance);
            } else {
                $member->wallet->addTotalBalanceByUnit($unit_id, $total_balance);
            }

            WalletLog::input($member->wallet_id, $order->sn, $total_amount * 100, $total_balance, $unit_id);

            DB::commit();

            return $order->sn;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * 使用充值卡充值
     *
     * @param $product_recharge_id
     * @param $member_id
     * @param string $remark
     * @return string
     * @throws \Exception
     */
    public static function exchangeRechargeCard($product_recharge_id, $member_id, $remark = '')
    {

        DB::beginTransaction();

        try {

            $recharge = ProductRecharge::findOneByID($product_recharge_id);

            $order = Order::getRechargeOrder($member_id, $recharge->denomination, $recharge->denomination, $recharge->unit_id, $remark);

            $order->complete()->save();

            $member = Member::findOneByID($member_id, ['wallet']);

            $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);

            if ($recharge->denomination > 0) {
                WalletRecharge::generate($member->wallet_id, $order->sn, $recharge->denomination, $recharge->unit_id, BaseDataModel::DISABLE, WalletRecharge::CHANNEL_PLATFORM);
                $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);
                WalletLog::input($member->wallet_id, $order->sn, $recharge->denomination, $total_balance, $recharge->unit_id);
            }

            if ($recharge->give_amount > 0) {
                WalletRecharge::generate($member->wallet_id, $order->sn, $recharge->give_amount, $recharge->unit_id, BaseDataModel::ENABLE, WalletRecharge::CHANNEL_PLATFORM);
                $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);
                WalletLog::input($member->wallet_id, $order->sn, $recharge->give_amount, $total_balance, $recharge->unit_id);
            }

            if (WalletUnit::hasRow($member->wallet_id, $recharge->unit_id)) {
                $member->wallet->setTotalBalanceByUnit($recharge->unit_id, $total_balance);
            } else {
                $member->wallet->addTotalBalanceByUnit($recharge->unit_id, $total_balance);
            }

            DB::commit();
            return $order->sn;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * 使用充值卡充值
     *
     * @param $product_recharge_id
     * @param $order_sn
     * @return bool
     * @throws \Exception
     */
    public static function rechargeCard($product_recharge_id, $order_sn)
    {

        DB::beginTransaction();

        try {
            $order = Order::findOneBySN($order_sn, ['carts']);

            $recharge = ProductRecharge::findOneByID($product_recharge_id);

            $member = Member::findOneByID($order->member_id, ['wallet']);

            $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);

            if ($recharge->denomination > 0) {
                WalletRecharge::generate($member->wallet_id, $order->sn, $recharge->denomination * 100, $recharge->unit_id, BaseDataModel::DISABLE, WalletRecharge::CHANNEL_PLATFORM);
                $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);
                WalletLog::input($member->wallet_id, $order->sn, $recharge->denomination * 100, $total_balance, $recharge->unit_id);
            }

            if ($recharge->give_amount > 0) {
                WalletRecharge::generate($member->wallet_id, $order->sn, $recharge->give_amount * 100, $recharge->unit_id, BaseDataModel::ENABLE, WalletRecharge::CHANNEL_PLATFORM);
                $total_balance = WalletRecharge::getTotalBalance($member->wallet_id, $recharge->unit_id);
                WalletLog::input($member->wallet_id, $order->sn, $recharge->give_amount * 100, $total_balance, $recharge->unit_id);
            }

            if (WalletUnit::hasRow($member->wallet_id, $recharge->unit_id)) {
                $member->wallet->setTotalBalanceByUnit($recharge->unit_id, $total_balance);
            } else {
                $member->wallet->addTotalBalanceByUnit($recharge->unit_id, $total_balance);
            }

            DB::commit();
            return $order->sn;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
