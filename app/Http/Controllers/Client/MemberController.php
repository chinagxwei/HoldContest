<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\BaseDataModel;
use App\Models\Member\Member;
use App\Models\Member\MemberAddress;
use App\Models\Member\MemberCompetition;
use App\Models\Member\MemberGameAccount;
use App\Models\Member\MemberMessage;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends PlatformController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    /**
     * 个人信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function userinfo(Request $request)
    {
        $user_id = auth('api')->id();

        $res = Member::findOneByUser($user_id, ['wallet', 'banInfo', 'vipInfo', 'gameAccounts']);

        return self::successJsonResponse($res);
    }

    /**
     * 参赛信息列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function competitionLogs(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new MemberCompetition())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 会员消息列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function messages(Request $request)
    {
        $param = $request->all();
        $param['status'] = BaseDataModel::ENABLE;
        $res = (new MemberMessage())->searchBuild($param)->paginate();
        return self::successJsonResponse($res);
    }

}
