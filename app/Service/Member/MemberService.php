<?php

namespace App\Service\Member;

use App\Models\Member\Member;

use App\Models\System\Unit;
use App\Models\Wallet\Wallet;
use App\Service\Utils\SmsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberService
{
    public static function generate()
    {

        DB::beginTransaction();

        try {
            date('YmdHis');

            $username = 'user_' . date('YmdHis') . mt_rand(100000, 999999);

            $baseUser = [
                'username' => $username,
                'email' => "{$username}@hcsystem.com",
                'password' => bcrypt($username),
                'user_type' => \App\Models\User::USER_TYPE_MEMBER,
            ];

            $user = new \App\Models\User();

            $user->fill($baseUser)->save();

            $member = new Member();

            Wallet::generate();

            $wallet = Wallet::lastOne();

            $member->wallet_id = $wallet->id;
            $member->order_income_config_id = 1;
            $member->register_type = 0;
            $member->develop = 1;
            $member->nickname = $username;

            if ($user->member()->save($member)) {
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

    public static function register($username, $password, $mobile, $code)
    {

    }

    /**
     * @param $mobile
     * @param $type
     * @return bool
     * @throws GuzzleException
     */
    public static function sendCode($mobile, $type = 0)
    {
        if (!preg_match('#^1\d{10}$#', $mobile)) {
            throw new \Exception('手机号码格式不正确');
        }
        $code = mt_rand(100000, 999999);
        $content = "【嗨玩电竞】您的验证码为:{$code},在5分钟内有效！如非本人操作请忽视本条信息。";
        (new SmsService())->setPhone($mobile)->setContent($content)->sendMosSms();
        return Cache::add("{$type}_mobile_{$mobile}", $code, now()->addMinutes(5));
    }

    public static function bindWechatMiniProgramAccount($openid, $member_id)
    {

    }

    public static function bindWechatOfficeAccount($openid, $member_id)
    {

    }
}
