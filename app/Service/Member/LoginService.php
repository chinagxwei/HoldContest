<?php

namespace App\Service\Member;

use App\Models\Member\Member;
use Illuminate\Support\Facades\Cache;

class LoginService
{
    private $username;

    private $password;

    private $mobile;

    private $code;

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
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function defaultLogin()
    {
        if (empty($this->username) || empty($this->password)) {
            throw new \Exception("参数错误");
        }

        if ($token = auth('api')->attempt([
            'username' => $this->username,
            'password' => $this->password,
        ])) {
            return $token;
        } else {
            throw new \Exception("用户名或密码错误！");
        }
    }

    /**
     * @throws \Exception
     */
    public function loginByMobile()
    {
        if (empty($this->mobile) || empty($this->code)) {
            throw new \Exception("参数错误");
        }

        if ($code = Cache::get("mobile_{$this->mobile}")) {
            if ("$code" === "{$this->code}") {
                $creator = Member::findOneByMobile($this->mobile, ['creator']);
                if ($token = auth('api')->attempt([
                    'username' => $creator->username,
                    'email' => $creator->email,
                    'user_type' => 1
                ])) {
                    Cache::forget("mobile_{$this->mobile}");
                    return $token;
                } else {
                    throw new \Exception("登录失败");
                }
            }
            throw new \Exception("验证码校验失败");
        }

        throw new \Exception("验证码失效");
    }
}
