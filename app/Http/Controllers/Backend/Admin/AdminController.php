<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\PlatformController;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends PlatformController
{
    protected $controller_event_text = "平台管理员";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $res = (new Admin())->searchBuild($request->all(), ['creator', 'role'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');
            $param = $request->all();
            if ($id <= 0) {
                $this->validate($request, [
                    'username' => 'required|min:6',
                    'password' => 'required|min:6',
                    'role_id' => 'required',
                ]);
                $model = new User();

                $model->registerManager($request->all());

                $admin = new Admin();

                if (!empty($param['remark'])) {
                    $admin->setRemark($param['remark']);
                }

                $model->admin()->save($admin);

                $this->saveEvent($model->username);

            } else {
                $admin = Admin::findOneByID($id);

                $admin->setMobile($param['mobile'])->setAdminRole($param['role_id'])->save();

            }
            return self::successJsonResponse($admin);
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('id')) {

            if ($admin = Admin::findOneByID($id)) {

                if ($admin->user->isSuperManager()){
                    return self::failJsonResponse();
                }

                $this->deleteEvent($admin->nickname);

                $admin->user()->delete();

                $admin->delete();

                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
