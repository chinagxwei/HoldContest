<?php

namespace App\Service\Member;

use App\Models\Admin\Admin;
use App\Models\Member\Member;
use App\Models\User;
use App\Models\Wallet\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterService
{
    private $username;

    private $password;

    private $mobile;

    private $promotion_sn;

    private $role_id;


    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @param mixed $promotion_sn
     */
    public function setPromotionSN($promotion_sn)
    {
        $this->promotion_sn = $promotion_sn;
        return $this;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }


    /**
     * @return false|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function generateManager()
    {

        if (empty($this->username) || empty($this->password) || empty($this->role_id)) {
            throw new \Exception("参数错误");
        }

        $user = new User();

        $user->registerManager(
            [
                'username' => $this->username,
                'password' => $this->password,
                'role_id' => $this->role_id,
            ]
        );
        $admin = new Admin();
        return $user->admin()->save($admin);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function generateMember($register_type = 2, $develop = 0)
    {
        DB::beginTransaction();

        try {
            $user = new User();

            $user->registerMember(
                [
                    'username' => $this->username,
                    'password' => $this->password,
                ]
            );

            if ($this->member($user, $register_type, $develop)) {
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
        return false;
    }

    public function generateMemberByPlatform($register_type = 0, $develop = 1)
    {
        DB::beginTransaction();

        try {
            date('YmdHis');

            $username = $this->username ?? 'user_' . date('YmdHis') . mt_rand(100000, 999999);

            $password = $this->password ? bcrypt($this->password) : bcrypt($username);

            $baseUser = [
                'username' => $username,
                'email' => "{$username}@hcsystem.com",
                'password' => $password,
                'user_type' => \App\Models\User::USER_TYPE_MEMBER,
            ];

            $user = new \App\Models\User();

            $user->fill($baseUser)->save();

            if ($this->member($user, $register_type, $develop)) {
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
        return false;
    }

    /**
     * @param User $user
     * @param $register_type
     * @param $develop
     * @return mixed
     */
    private function member($user, $register_type, $develop)
    {
        $member = new Member();

        Wallet::generate();

        $wallet = Wallet::lastOne();

        $member->wallet_id = $wallet->id;
        $member->order_income_config_id = 1;
        $member->register_type = $register_type;
        $member->develop = $develop;
        $member->nickname = $user->username;
        if (!empty($this->mobile)) {
            $member->mobile = $this->mobile;
        }
        $res = $user->member()->save($member);
        if (!empty($this->promotion_sn)) {
            if ($promotionMember = Member::findOneByPromotion($this->promotion_sn)) {
                $member->parent_id = $promotionMember->id;
                $promotionMember->children()->attach($member->id);
            }
        }
        return $res;
    }
}
