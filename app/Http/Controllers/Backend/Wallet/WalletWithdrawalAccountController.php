<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletWithdrawalAccount;
use Illuminate\Http\Request;

class WalletWithdrawalAccountController extends PlatformController
{
    protected $controller_event_text = "提现账户管理";

    public function index(Request $request)
    {
        $res = (new WalletWithdrawalAccount())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = intval($request->get('id'));

            try {
                 $this->validate($request, [
                    'member_id' => 'required',
                    'account_type' => 'required',
                    'contact' => 'required',
                    'mobile' => 'required',
                    'account' => 'required',
                    'bank_name' => 'required',
                ]);

                if ($id > 0) {
                    $model = WalletWithdrawalAccount::findOneByID($id);
                } else {
                    $model = new WalletWithdrawalAccount();
                }

                if ($model->fill($request->all())->save()) {
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
                }
            } catch (\Exception $e) {
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = WalletWithdrawalAccount::findOneByID($id)) {
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
        if ($id = intval($request->get('id'))) {
            if ($model = WalletWithdrawalAccount::findOneByID($id)) {
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

        return self::failJsonResponse();
    }
}
