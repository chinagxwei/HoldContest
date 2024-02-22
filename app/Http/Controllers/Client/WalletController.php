<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\PlatformController;
use App\Models\User;
use App\Models\Wallet\WalletLog;
use App\Models\Wallet\WalletUnit;
use App\Models\Wallet\WalletWithdrawal;
use App\Models\Wallet\WalletWithdrawalAmountConfig;
use App\Service\Order\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletController extends PlatformController
{

    /**
     * 钱包信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member = $user->member) {
            $res = $member->wallet;
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 钱包日志
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member = $user->member) {
            $param = $request->all();
            $param['wallet_id'] = $member->wallet_id;
            $res = (new WalletLog())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 钱包提款申请
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawApply(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member = $user->member) {
            $param = $request->all();
            if (empty($param['withdraw_account_id']) || empty($param['withdraw_amount_config_id'])) {
                return self::failJsonResponse("申请参数错误");
            }
            $wu = WalletUnit::findOne($member->wallet_id, 1);

            if (empty($wu)) {
                return self::failJsonResponse("账户余额不足");
            }

            $amountConfig = WalletWithdrawalAmountConfig::findOneByID($param['withdraw_amount_config_id']);

            $vipInfo = $member->vipInfo;

            if (empty($vipInfo)) {
                if ($wu->total_balance < $amountConfig->amount) {
                    return self::failJsonResponse("账户余额不足");
                }
                $amount = $amountConfig->amount;
            } else {
                if ($wu->total_balance < $amountConfig->vip_amount) {
                    return self::failJsonResponse("账户余额不足");
                }
                $amount = $amountConfig->vip_amount;
            }

            DB::beginTransaction();
            try {

                $order_sn = TradeService::withdraw($member->id, $member->wallet_id, $amount, 1);

                WalletWithdrawal::generate($member->wallet_id, $param['withdraw_account_id'], $order_sn, $amount);

                DB::commit();

                return self::successJsonResponse();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                DB::rollBack();
                return self::failJsonResponse('申请提款失败');
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 提款申请列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawAmounts(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member = $user->member) {
            $param = $request->all();
            $param['wallet_id'] = $member->wallet_id;
            $res = (new WalletWithdrawal())->searchBuild($param)->orderBy('created_at','desc')->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

}
