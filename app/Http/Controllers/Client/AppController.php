<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\App\AppPublishLog;
use App\Models\BaseDataModel;
use App\Models\Goods\ProductRecharge;
use App\Models\Goods\ProductVIP;
use App\Models\System\SystemAgreement;
use App\Models\Wallet\WalletWithdrawalAmountConfig;
use App\Service\Member\MemberService;
use App\Service\Utils\SmsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AppController extends PlatformController
{

    /**
     * 最新版
     * @return void
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function latestVersion(Request $request)
    {
        $res = AppPublishLog::findLast();
        return self::successJsonResponse($res);
    }

    /**
     * 提款金额配置列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawConfigs(Request $request)
    {
        $res = (new WalletWithdrawalAmountConfig())
            ->searchBuild(['show' => BaseDataModel::ENABLE], ['unit'])
            ->paginate(50);
        return self::successJsonResponse($res);
    }

    /**
     * VIP配置列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vipConfigs(Request $request)
    {
        $res = (new ProductVIP())->searchBuild(['show' => BaseDataModel::ENABLE], ['unit'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * 充值配置列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rechargeConfigs(Request $request)
    {
        $res = (new ProductRecharge())->searchBuild(['show' => BaseDataModel::ENABLE], ['unit'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * 发送短信 0注册 1登录 2修改密码 3绑定提款账户
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function sendSms(Request $request)
    {
        if ($mobile = $request->input('mobile', '')) {
            $type = $request->input('type', 0);
            try {
                MemberService::sendCode($mobile, $type);
                return self::successJsonResponse();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return self::failJsonResponse($e->getMessage());
            }

        }

        return self::failJsonResponse('手机号为空');
    }
}
