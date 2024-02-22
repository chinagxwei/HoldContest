<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\Wallet\WalletWithdrawal;
use App\Models\Wallet\WalletWithdrawalAmountConfig;
use Illuminate\Http\Request;

class WalletWithdrawalAmountConfigController extends PlatformController
{
    protected $controller_event_text = "提现金额配置管理";

    public function index(Request $request){
        $res = (new WalletWithdrawalAmountConfig())->searchBuild($request->all(),['unit'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');

            try {
                $this->validate($request, [
                    'title' => 'required',
                    'amount' => 'required',
                    'vip_amount' =>  'required',
                ]);

                if ($id > 0) {
                    $model = WalletWithdrawalAmountConfig::findOneByID($id);
                } else {
                    $model = new WalletWithdrawalAmountConfig();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->title);
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
        if ($request->isMethod('POST') && $id = $request->input('id')) {
            if ($model = WalletWithdrawal::findOneByID($id)) {
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
            if ($model = WalletWithdrawalAmountConfig::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
