<?php

namespace App\Service\Vip;

use App\Models\Goods\ProductVIP;
use App\Models\Member\MemberVIP;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VipService
{
    /**
     * @param $vip_id
     * @param $member_id
     * @return string
     * @throws \Exception
     */
    public static function platformCustom($vip_id, $member_id)
    {
        DB::beginTransaction();

        try {
            $order = Order::getVipOrder($member_id, 0, 0, 1, null);

            $order->complete()->save();

            $productVIP = ProductVIP::findOneByID($vip_id);

            $started_at = time();

            $ended = $started_at + ($productVIP->day * 60 * 60 * 24);

            MemberVIP::generate($member_id, $vip_id, $order->sn, $started_at, $ended, MemberVIP::CHANNEL_PLATFORM);

            DB::commit();
            return $order->sn;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $vip_id
     * @param $member_id
     * @return string
     * @throws \Exception
     */
    public static function memberTrade($vip_id, $member_id)
    {
        DB::beginTransaction();

        try {
            $productVIP = ProductVIP::findOneByID($vip_id);

            $order = Order::getVipOrder($member_id, $productVIP->price, $productVIP->price, $productVIP->unit_id, null);

            $order->save();

            DB::commit();
            return $order->sn;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
