<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletLog;
use Illuminate\Http\Request;

class WalletLogController extends PlatformController
{
    protected $controller_event_text = "钱包日志管理";

    public function index(Request $request)
    {
        $res = (new WalletLog())->searchBuild($request->all())->paginate();
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
                    'amount' => 'required',
                    'type' => 'required'
                ]);

                if ($id > 0) {
                    $model = WalletLog::findOneByID($id);
                } else {
                    $model = new WalletLog();
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
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = WalletLog::findOneByID($id)) {
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
            if ($model = WalletLog::findOneByID($id)) {
                $this->deleteEvent($model->wallet_id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
