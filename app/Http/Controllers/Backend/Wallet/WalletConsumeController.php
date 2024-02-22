<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletConsume;
use Illuminate\Http\Request;

class WalletConsumeController extends PlatformController
{
    protected $controller_event_text = "消费管理";

    public function index(Request $request){
        $res = (new WalletConsume())->searchBuild($request->all(),['order.unit'])->paginate();
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
                    'wallet_id' => 'required',
                    'order_sn' => 'required',
                     'wallet_recharge_id' => 'required',
                     'member_id' => 'required',
                     'amount' => 'required'
                ]);

                if ($id > 0) {
                    $model = WalletConsume::findOneByID($id);
                } else {
                    $model = new WalletConsume();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->order_sn);
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
            if ($model = WalletConsume::findOneByID($id)) {
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
            if ($model = WalletConsume::findOneByID($id)) {
                $this->deleteEvent($model->order_sn);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
