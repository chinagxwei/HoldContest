<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderController extends PlatformController
{
    protected $controller_event_text = "订单管理";

    public function index(Request $request){
        $res = (new Order())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = Order::findOneByID($id)) {
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
            if ($model = Order::findOneByID($id)) {
                $this->deleteEvent($model->sn);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
