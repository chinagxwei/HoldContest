<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\Member\Member;
use Illuminate\Http\Request;

class MemberController extends PlatformController
{
    protected $controller_event_text = "会员管理";

    public function index(Request $request){
        $res = (new Member())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = Member::findOneByID($id)) {
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
            if ($model = Member::findOneByID($id)) {
                $this->deleteEvent($model->id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
