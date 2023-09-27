<?php

namespace App\Http\Controllers\Backend\Goods;

use App\Http\Controllers\PlatformController;
use App\Models\Goods\ProductRecharge;
use Illuminate\Http\Request;

class ProductRechargeController extends PlatformController
{
    protected $controller_event_text = "充值管理";

    public function index(Request $request)
    {
        $res = (new ProductRecharge())->searchBuild($request->all(), ['unit'])->paginate();
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
                    'denomination' => 'numeric',
                    'give_amount' => 'numeric',
                    'unit_id' => 'numeric',
                    'show' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = ProductRecharge::findOneByID($id);
                } else {
                    $model = new ProductRecharge();
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
            if ($model = ProductRecharge::findOneByID($id)) {
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
            if ($model = ProductRecharge::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
