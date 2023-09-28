<?php

namespace App\Service\Install;

use App\Models\Admin\AdminNavigation;
use App\Models\Admin\AdminRole;
use App\Models\Goods\ProductRecharge;
use App\Models\Goods\ProductVIP;
use App\Models\Order\OrderIncomeConfig;
use App\Models\System\Unit;

class Setup
{
    public static function add()
    {

        $admin = self::adminData();

        self::menuData($admin->created_by);

        $role = self::roleData($admin->created_by);

        $admin->setAdminRole($role->id)->save();

        self::insertBaseData($admin->created_by);
    }

    /**
     * @return \App\Models\Admin\Admin|\Illuminate\Database\Eloquent\Model
     */
    private static function adminData()
    {
        $baseUser = [
            'username' => 'admin',
            'email' => 'admin@hcsystem.com',
            'password' => bcrypt('admin123456'),
            'user_type' => \App\Models\User::USER_TYPE_PLATFORM_SUPER_MANAGER,
        ];

        $user = new \App\Models\User();

        $user->fill($baseUser)->save();

        return $user->admin()->save(new \App\Models\Admin\Admin(['nickname' => 'admin'])) ? $user->admin : null;
    }

    private static function menuData($created_by)
    {
        $systemMenus = AdminNavigation::generateParent("系统管理", "line-menu", $created_by, 7, './system', './system');
        $systemData = BaseRoutesData::getSystemData($systemMenus->id, $created_by);
        AdminNavigation::query()->insert($systemData);
        $walletMenus = AdminNavigation::generateParent("钱包管理", "line-menu", $created_by, 6, './goods', './goods');
        $walletData = BaseRoutesData::getWalletData($walletMenus->id, $created_by);
        AdminNavigation::query()->insert($walletData);
        $goodsMenus = AdminNavigation::generateParent("商品管理", "line-menu", $created_by, 5, './goods', './goods');
        $goodsData = BaseRoutesData::getGoodsData($goodsMenus->id, $created_by);
        AdminNavigation::query()->insert($goodsData);
        $activityMenus = AdminNavigation::generateParent("活动管理", "line-menu", $created_by, 4, './goods', './goods');
        $activityData = BaseRoutesData::getActivityData($activityMenus->id, $created_by);
        AdminNavigation::query()->insert($activityData);
        $memberMenus = AdminNavigation::generateParent("会员管理", "line-menu", $created_by, 3, './goods', './goods');
        $memberData = BaseRoutesData::getMemberData($memberMenus->id, $created_by);
        AdminNavigation::query()->insert($memberData);
        $orderMenus = AdminNavigation::generateParent("订单管理", "line-menu", $created_by, 2, './goods', './goods');
        $orderData = BaseRoutesData::getOrderData($orderMenus->id, $created_by);
        AdminNavigation::query()->insert($orderData);
        $competitionMenus = AdminNavigation::generateParent("赛事管理", "line-menu", $created_by, 1, './competition-game', './competition-game');
        $competitionData = BaseRoutesData::getCompetitionData($competitionMenus->id, $created_by);
        AdminNavigation::query()->insert($competitionData);
    }

    private static function roleData($created_by)
    {
        if ($role = AdminRole::generate("管理员", $created_by)) {
            $ids = AdminNavigation::getParentAll()->map(function ($v) {
                return $v->id;
            });


            $role->navigations()->sync($ids->toArray());

            return $role;
        }
        return null;
    }

    private static function insertBaseData($created_by)
    {
        $time = time();
        $unitData = BaseUnitData::getData($created_by, $time);
        Unit::query()->insert($unitData);
        $vipData = BaseVIPData::getData($created_by, $time);
        ProductVIP::query()->insert($vipData);
        $rechargeData = BaseRechargeData::getData($created_by, $time);
        ProductRecharge::query()->insert($rechargeData);
        $incomeData = BaseIncomeConfigData::getData($created_by, $time);
        OrderIncomeConfig::query()->insert($incomeData);
    }
}
