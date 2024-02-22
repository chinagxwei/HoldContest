<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\Member\Member;
use App\Models\Member\MemberGameAccount;
use App\Service\Competition\CompetitionEventService;
use App\Service\Member\MemberService;
use App\Service\Member\RegisterService;
use App\Service\Vip\VipService;
use App\Service\Wallet\RechargeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends PlatformController
{
    protected $controller_event_text = "会员管理";

    public function index(Request $request)
    {
        $res = (new Member())->searchBuild($request->all(), ['wallet', 'vipInfo', 'banInfo', 'wallet.accounts', 'games'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = $request->input('id')) {
            if ($model = Member::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('id')) {
            if ($model = Member::findOneByID($id)) {
                $this->deleteEvent($model->id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function generate(Request $request)
    {

        (new RegisterService())->generateMemberByPlatform();

        return self::successJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function setRecharge(Request $request)
    {
        if ($id = $request->input('id')) {
            $param = $request->all();
            $order_sn = RechargeService::platformCustom($id, $param['amount'], $param['amount'], $param['unit_id'], $param['remark']);
            $this->saveEvent("充值：{$order_sn}");
            return self::successJsonResponse();
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function setVIP(Request $request)
    {
        $param = $request->all();
        if (($id = $request->input('id')) && !empty($param['vip_id'])) {

            $member = Member::findOneByID($id, ['vipInfo']);

            if (empty($member->vipInfo)) {
                $order_sn = VipService::platformCustom($param['vip_id'], $id);

                if ($order_sn) {
                    $this->saveEvent("充值VIP：{$order_sn}");

                    return self::successJsonResponse();
                }
            } else {
                return self::failJsonResponse('VIP已获得');
            }
        }

        return self::failJsonResponse();
    }

    public function setGameAccount(Request $request)
    {
        $param = $request->all();

        if (!empty($param['id']) && !empty($param['game_id']) && !empty($param['nickname'])) {
            $account_type = $request->input('account_type');
            $nickname = $request->input('nickname');
            $game_code = $request->input('game_code');
            try {
                $res = CompetitionEventService::setGameAccount($param['id'], $param['game_id'], $account_type, $nickname, $game_code);
                return self::successJsonResponse();
            } catch (\Exception $e) {
                return self::failJsonResponse($e->getMessage());
            }
        }

        return self::failJsonResponse();
    }

    public function setWithdrawAccount(Request $request)
    {

    }
}
