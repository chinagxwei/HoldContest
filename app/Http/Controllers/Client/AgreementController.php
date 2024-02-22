<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\BaseDataModel;
use App\Models\System\SystemAgreement;
use Illuminate\Http\Request;

class AgreementController extends PlatformController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['memberServiceTerms', 'memberPrivacyAgreement', 'memberRechargeAgreement', 'membershipAgreement']]);
    }

    /**
     * 会员服务条款
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberServiceTerms(Request $request)
    {
        if ($model = SystemAgreement::findOneByID(4)) {
            return self::successJsonResponse($model);
        }
    }

    /**
     * 会员隐私协议
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberPrivacyAgreement(Request $request)
    {
        if ($model = SystemAgreement::findOneByID(2)) {
            return self::successJsonResponse($model);
        }
    }

    /**
     * 会员充值协议
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberRechargeAgreement(Request $request)
    {
        if ($model = SystemAgreement::findOneByID(3)) {
            return self::successJsonResponse($model);
        }
    }

    /**
     * 会员协议
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberShipAgreement(Request $request)
    {
        if ($model = SystemAgreement::findOneByID(1)) {
            return self::successJsonResponse($model);
        }
    }


    /**
     * 协议列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agreements(Request $request)
    {
        $param = $request->all();
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemAgreement())->searchBuild($param)->paginate();
        return self::successJsonResponse($res);
    }
}
