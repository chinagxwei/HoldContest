<?php

namespace App\Http\Controllers\Backend\Wechat;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wechat\WechatOfficeAccount;
use Illuminate\Http\Request;

class WechatOfficeAccountController extends PlatformController
{
    protected $controller_event_text = "公众号会员管理";

    public function index(Request $request){
        $res = (new WechatOfficeAccount())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = WechatOfficeAccount::findOneByID($id)) {
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
            if ($model = WechatOfficeAccount::findOneByID($id)) {
                $this->deleteEvent($model->nickname);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
