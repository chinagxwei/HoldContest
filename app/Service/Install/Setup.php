<?php

namespace App\Service\Install;

use App\Models\Admin\AdminMenus;
use App\Models\Admin\AdminRoles;

class Setup
{
    public static function add()
    {

        $admin = self::adminData();

        self::menuData($admin->created_by);

        $role = self::roleData($admin->created_by);

        $admin->setAdminRole($role->id)->save();
    }

    /**
     * @return \App\Models\Admin\Admin|\Illuminate\Database\Eloquent\Model
     */
    private static function adminData()
    {
        $baseUser = [
            'username' => 'admin',
            'email' => 'admin@ddsystem.com',
            'password' => bcrypt('admin123456'),
            'user_type' => \App\Models\User::USER_TYPE_PLATFORM_SUPER_MANAGER,
        ];

        $user = new \App\Models\User();

        $user->fill($baseUser)->save();

        return $user->admin()->save(new \App\Models\Admin\Admin(['nickname' => 'admin']));
    }

    private static function menuData($created_by)
    {
        $time = time();
        $systemMenus = AdminMenus::generateParent("系统管理", "line-chart", $created_by, 7, './system', './system');
        $systemData = BaseRoutesData::getSystemData($systemMenus->id, $created_by, $time);
        AdminMenus::query()->insert($systemData);
    }

    private static function roleData($created_by)
    {
        if ($role = AdminRoles::generate("管理员", $created_by)) {
            $ids = AdminMenus::getParentAll()->map(function ($v) {
                return $v->id;
            });


            $role->navigations()->sync($ids->toArray());

            return $role;
        }
        return null;
    }
}
