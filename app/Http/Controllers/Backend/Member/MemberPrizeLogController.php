<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Member\Member;
use App\Models\Member\MemberPrizeLog;
use Illuminate\Http\Request;

class MemberPrizeLogController extends PlatformController
{
    protected $controller_event_text = "会员奖励管理";

    public function index(Request $request){
        $res = (new MemberPrizeLog())->searchBuild($request->all())->paginate();
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
                    'member_id' => 'required',
                    'quest_id' => 'required',
                    'order_sn' => 'required',
                    'prize_type' => 'required'
                ]);

                if ($id > 0) {
                    $model = MemberPrizeLog::findOneByID($id);
                } else {
                    $model = new MemberPrizeLog();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->member_id);
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
            if ($model = MemberPrizeLog::findOneByID($id)) {
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
            if ($model = MemberPrizeLog::findOneByID($id)) {
                $this->deleteEvent($model->member_id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
