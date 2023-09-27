<?php

namespace App\Http\Controllers\Backend\LuckyDraws;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\LuckyDraws\LuckyDrawsItem;
use Illuminate\Http\Request;

class LuckyDrawsItemController extends PlatformController
{
    protected $controller_event_text = "抽奖项管理";

    public function index(Request $request){
        $res = (new LuckyDrawsItem())->searchBuild($request->all())->paginate();
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
                    'image' => 'required',
                    'goods_id' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = LuckyDrawsItem::findOneByID($id);
                } else {
                    $model = new LuckyDrawsItem();
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
            if ($model = LuckyDrawsItem::findOneByID($id)) {
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
            if ($model = LuckyDrawsItem::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
