<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\PlatformController;
use App\Models\Member\MemberAddress;
use App\Models\User;
use Illuminate\Http\Request;

class MemberAddressController extends PlatformController
{
    protected $controller_event_text = "会员地址管理";

    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new MemberAddress())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                try {
                    $this->validate($request, [
                        'contact' => 'required',
                        'mobile' => 'required',
                        'detail_info' => 'required',
                    ]);

                    if ($id > 0) {
                        $model = MemberAddress::findOneByMemberAndID($id, $member_id);
                    } else {
                        $model = new MemberAddress();
                    }

                    if ($model && $model->fill($request->all())->save()) {
                        $text = [
                            $model->id,
                            $model->member_id,
                            $model->contact,
                            $model->detail_info
                        ];
                        $this->saveEvent(join(" | ", $text));
                        return self::successJsonResponse();
                    }else{
                        return self::failJsonResponse('保存地址失败');
                    }
                } catch (\Exception $e) {
                    return self::failJsonResponse($e->getMessage());
                }
            }

        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDefault(Request $request)
    {
        if ($request->isMethod('POST') && $id = $request->input('address_id')) {
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                if ($model = MemberAddress::findOneByMemberAndID($id, $member_id)) {
                    if ($model->setDefault()){
                        return self::successJsonResponse();
                    }
                    return self::failJsonResponse('默认地址设置失败');
                }
                return self::failJsonResponse('关联地址不存在');
            }
            return self::failJsonResponse('关联会员不存在');
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('address_id')) {
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                if ($model = MemberAddress::findOneByMemberAndID($id, $member_id)) {
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
        }

        return self::failJsonResponse();
    }
}
