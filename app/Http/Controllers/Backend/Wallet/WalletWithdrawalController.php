<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletWithdrawal;
use Illuminate\Http\Request;

class WalletWithdrawalController extends PlatformController
{
    protected $controller_event_text = "提现管理";

    public function index(Request $request){
        $res = (new WalletWithdrawal())->searchBuild($request->all())->paginate();
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
                    'wallet_id' => 'required',
                    'order_sn' => 'required',
                    'amount' =>  'required',
                ]);

                if ($id > 0) {
                    $model = WalletWithdrawal::findOneByID($id);
                } else {
                    $model = new WalletWithdrawal();
                }

                if ($model->fill($request->all())->save()) {
                    $text = [
                        $model->id,
                        $model->wallet_id,
                        $model->order_sn,
                        $model->amount
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
        if ($id = intval($request->get('id'))) {
            if ($model = WalletWithdrawal::findOneByID($id)) {
                $text = [
                    $model->id,
                    $model->wallet_id,
                    $model->order_sn,
                    $model->amount
                ];
                $this->deleteEvent(join(" | ", $text));
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
