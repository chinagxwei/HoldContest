<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Order\OrderIncomeConfig;
use Illuminate\Http\Request;

class OrderIncomeConfigController extends PlatformController
{
    protected $controller_event_text = "订单收益配置";

    public function index(Request $request){
        $res = (new OrderIncomeConfig())->searchBuild($request->all())->paginate();
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
                    'title' => 'required',
                    'withdraw_point' => 'numeric',
                    'vip_withdraw_point' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = OrderIncomeConfig::findOneByID($id);
                } else {
                    $model = new OrderIncomeConfig();
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
            if ($model = OrderIncomeConfig::findOneByID($id)) {
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
            if ($model = OrderIncomeConfig::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
