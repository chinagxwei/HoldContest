<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Member\MemberGameAccount;
use App\Models\User;
use App\Models\Wallet\WalletWithdrawalAccount;
use App\Service\Utils\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WalletWithdrawalAccountController extends PlatformController
{
    protected $controller_event_text = "会员提现账户管理";

    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new WalletWithdrawalAccount())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');
            /** @var User $user */
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                try {
                    $this->validate($request, [
                        'account_type' => 'required',
                        'contact' => 'required',
                        'mobile' => 'required',
                        'account' => 'required',
                        'validate_code' => 'required',
                    ]);
                    $param = $request->all();
                    $param['member_id'] = $member_id;
                    if ($code = Cache::get(SmsService::BIND_ACCOUNT . "_mobile_{$param['mobile']}")) {
                        if ("$code" !== "{$param['validate_code']}") {
                            return self::failJsonResponse('验证码校验失败');
                        }
                        Cache::forget(SmsService::BIND_ACCOUNT . "_mobile_{$param['mobile']}");
                    } else {
                        return self::failJsonResponse('验证码校验失败');
                    }

                    if ($id > 0) {
                        $model = WalletWithdrawalAccount::findOneByMemberAndID($id, $member_id);
                    } else {
                        $model = new WalletWithdrawalAccount();
                    }

                    if ($model && $model->fill($param)->save()) {
                        $text = [
                            $model->id,
                            $model->account_type,
                            $model->contact,
                            $model->mobile,
                            $model->account,
                            $model->bank_name,
                        ];
                        $this->saveEvent(join(" | ", $text));
                        return self::successJsonResponse();
                    } else {
                        return self::failJsonResponse('保存提款账户失败');
                    }
                } catch (\Exception $e) {
                    return self::failJsonResponse($e->getMessage());
                }
            }

        }
        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = $request->input('withdrawal_account_id')) {
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                if ($model = WalletWithdrawalAccount::findOneByMemberAndID($id, $member_id)) {
                    return self::successJsonResponse($model);
                }
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('withdrawal_account_id')) {
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                if ($model = WalletWithdrawalAccount::findOneByMemberAndID($id, $member_id)) {
                    $text = [
                        $model->id,
                        $model->account_type,
                        $model->contact,
                        $model->mobile,
                        $model->account,
                        $model->bank_name,
                    ];

                    $this->deleteEvent(join(" | ", $text));
                    $model->delete();
                    return self::successJsonResponse();
                }
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }
}
