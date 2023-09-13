<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletRecharge;
use Illuminate\Http\Request;

class WalletRechargeController extends PlatformController
{
    protected $controller_event_text = "钱包充值管理";

    public function index(Request $request)
    {
        $res = (new WalletRecharge())->searchBuild($request->all())->paginate();
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
                    'denomination' => 'required',
                    'balance' => 'required',
                    'unit_id' => 'required',
                    'frozen' => 'required',
                    'channel' => 'required',
                    'gift' => 'required',
                ]);

                if ($id > 0) {
                    $model = WalletRecharge::findOneByID($id);
                } else {
                    $model = new WalletRecharge();
                }

                if ($model->fill($request->all())->save()) {
                    $text = [
                        $model->id,
                        $model->denomination,
                        $model->balance,
                        $model->unit_id,
                        $model->frozen,
                        $model->channel,
                        $model->gift,
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
            if ($model = WalletRecharge::findOneByID($id)) {
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
            if ($model = WalletRecharge::findOneByID($id)) {
                $text = [
                    $model->id,
                    $model->denomination,
                    $model->balance,
                    $model->unit_id,
                    $model->frozen,
                    $model->channel,
                    $model->gift,
                ];
                $this->deleteEvent(join(" | ", $text));
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
