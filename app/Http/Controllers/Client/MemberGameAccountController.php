<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\Member\Member;
use App\Models\Member\MemberGameAccount;
use App\Models\User;
use App\Service\Competition\CompetitionEventService;
use Illuminate\Http\Request;

class MemberGameAccountController extends PlatformController
{
    /**
     * 游戏账户绑定列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new MemberGameAccount())->searchBuild($param, ['game'])->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncAccount(Request $request)
    {
        if ($game_id = $request->input('game_id')) {
            /** @var User $user */
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                $account_type = $request->input('account_type');
                $nickname = $request->input('nickname');
                if (empty($nickname)){
                    return self::failJsonResponse("昵称不能为空");
                }
                try {
                    $res = CompetitionEventService::setGameAccount($member_id, $game_id, $account_type, $nickname);
                    return self::successJsonResponse();
                } catch (\Exception $e) {
                    return self::failJsonResponse($e->getMessage());
                }
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }
}
