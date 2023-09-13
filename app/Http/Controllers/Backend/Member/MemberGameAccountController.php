<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\Member\MemberGameAccount;
use Illuminate\Http\Request;

class MemberGameAccountController extends PlatformController
{
    protected $controller_event_text = "会员游戏账户管理";

    public function index(Request $request){
        $res = (new MemberGameAccount())->searchBuild($request->all())->paginate();
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
                    'game_id' => 'required',
                    'account_type' => 'required',
                    'nickname' => 'required',
                    'game_code' => 'required',
                ]);

                if ($id > 0) {
                    $model = MemberGameAccount::findOneByID($id);
                } else {
                    $model = new MemberGameAccount();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->nickname);
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
            if ($model = MemberGameAccount::findOneByID($id)) {
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
            if ($model = MemberGameAccount::findOneByID($id)) {
                $this->deleteEvent($model->nickname);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
