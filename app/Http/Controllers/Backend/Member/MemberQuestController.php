<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Member\Member;
use App\Models\Member\MemberQuest;
use Illuminate\Http\Request;

class MemberQuestController extends PlatformController
{
    protected $controller_event_text = "会员任务管理";

    public function index(Request $request){
        $res = (new MemberQuest())->searchBuild($request->all())->paginate();
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
                    'member_id' => 'required',
                    'quest_id' => 'required',
                ]);

                if ($id > 0) {
                    $model = MemberQuest::findOneByID($id);
                } else {
                    $model = new MemberQuest();
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
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = MemberQuest::findOneByID($id)) {
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
            if ($model = MemberQuest::findOneByID($id)) {
                $this->deleteEvent($model->member_id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
