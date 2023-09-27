<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\PlatformController;
use App\Models\Admin\AdminRole;
use Illuminate\Http\Request;

class AdminRoleController extends PlatformController
{
    protected $controller_event_text = "管理员角色";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $res = (new AdminRole())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($id = intval($request->get('id'))) {
            if ($model = AdminRole::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
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
                    'role_name' => 'required|min:5',
                ]);

                if ($id > 0) {
                    $model = AdminRole::findOneByID($id);
                } else {
                    $model = new AdminRole();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->role_name);
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
    public function delete(Request $request)
    {
        if ($id = intval($request->get('id'))) {
            if ($model = AdminRole::findOneByID($id)) {
                $this->deleteEvent($model->role_name);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
