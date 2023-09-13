<?php

namespace App\Http\Controllers\Backend\Member;

use App\Http\Controllers\PlatformController;
use App\Models\Member\MemberAddress;
use Illuminate\Http\Request;

class MemberAddressController extends PlatformController
{
    protected $controller_event_text = "会员地址管理";

    public function index(Request $request){
        $res = (new MemberAddress())->searchBuild($request->all())->paginate();
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
                    'default' => 'required',
                    'contact' => 'required',
                    'mobile' => 'required',
                    'detail_info' => 'required',
                ]);

                if ($id > 0) {
                    $model = MemberAddress::findOneByID($id);
                } else {
                    $model = new MemberAddress();
                }

                if ($model->fill($request->all())->save()) {
                    $text = [
                        $model->id,
                        $model->member_id,
                        $model->contact,
                        $model->detail_info
                    ];
                    $this->saveEvent(join(" | ", $text));
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
            if ($model = MemberAddress::findOneByID($id)) {
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
            if ($model = MemberAddress::findOneByID($id)) {
                $text = [
                    $model->id,
                    $model->member_id,
                    $model->contact,
                    $model->detail_info
                ];
                $this->deleteEvent(join(" | ", $text));
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
