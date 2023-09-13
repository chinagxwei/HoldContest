<?php

namespace App\Service\Install;

use App\Models\Admin\AdminMenus;
use App\Models\Admin\AdminRoles;
use Illuminate\Support\Facades\DB;

class BaseRoutesData
{

    public static function getSystemData($menus_id, $created_by, $time)
    {
        return [
            [
                'parent_id' => $menus_id,
                'navigation_name' => '协议管理',
                'navigation_link' => './system/agreement',
                'navigation_router' => 'platform/system/agreement',
                'navigation_sort' => 1,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '投诉管理',
                'navigation_link' => './system/complaint',
                'navigation_router' => 'platform/system/complaint',
                'navigation_sort' => 2,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '系统配置管理',
                'navigation_link' => './system/system-config',
                'navigation_router' => 'platform/system/system-config',
                'navigation_sort' => 3,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '导航管理',
                'navigation_link' => './system/navigation',
                'navigation_router' => 'platform/system/navigation',
                'navigation_sort' => 4,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '用户角色管理',
                'navigation_link' => './system/role',
                'navigation_router' => 'platform/system/role',
                'navigation_sort' => 5,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '用户管理',
                'navigation_link' => './system/manager',
                'navigation_router' => 'platform/system/manager',
                'navigation_sort' => 6,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'parent_id' => $menus_id,
                'navigation_name' => '管理员日志',
                'navigation_link' => './system/action-log',
                'navigation_router' => 'platform/system/action-log',
                'navigation_sort' => 7,
                'icon' => 'line-chart',
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ],
        ];
    }
}
