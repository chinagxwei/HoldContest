<?php

namespace App\Http\Controllers\Backend\Goods;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Goods\Goods;
use Illuminate\Http\Request;

class GoodsController extends PlatformController
{
    protected $controller_event_text = "商品管理";

    public function index(Request $request)
    {
        $param = $request->all();
        $res = (new Goods())->searchBuild($param, ['vip', 'recharge'])
            ->orderBy('relation_category')
            ->paginate($param['pageSize'] ?? 15);
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->get('id');

            try {
                $this->validate($request, [
                    'title' => 'required|min:1',
                    'stock' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = Goods::findOneByID($id);
                } else {
                    $model = new Goods();
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
        if ($request->isMethod('POST') && $id = $request->get('id')) {
            if ($model = Goods::findOneByID($id)) {
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
        if ($id = $request->get('id')) {
            if ($model = Goods::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }

}
