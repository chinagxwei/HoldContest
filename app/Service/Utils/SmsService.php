<?php

namespace App\Service\Utils;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SmsService
{
    // 0注册 1登录 2修改密码 3绑定提款账户

    const REGISTER = 0;

    const LOGIN = 1;

    const RESET_PASSWORD = 2;

    const BIND_ACCOUNT = 3;

    protected $phone;
    protected $content;

    protected $provider = [
        'smsbao' => [
            'user' => 'HWDJ',
            'pass' => '2467efe2c4c8544b2c4db5c035708fca',
            'url' => 'http://api.smsbao.com'
        ],
        'smsmos' => [
            'user' => 'hnhhw@hnhhw',
            'pass' => '2467efe2c4c8544b2c4db5c035708fca',
            'url' => 'http://ns.mosapi.cn:9051'
        ]
    ];

    private $statusStr = [
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    ];


    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     * @throws GuzzleException
     */
    public function sendBaoSms()
    {
        $this->init();

        $client = new \GuzzleHttp\Client(['base_uri' => $this->provider['smsmos']['url']]);

        $query = [
            'u' => $this->provider['smsbao']['user'],
            'p' => $this->provider['smsbao']['pass'],
            'm' => $this->phone,
            'c' => urlencode($this->content)
        ];

        $response = $client->request("GET", '/sms', [
            'query' => $query
        ]);

        $bodyStr = (string)$response->getBody();

        Log::info($bodyStr);

        if (!empty($bodyStr)) {
            return $this->statusStr[$bodyStr];
        } else {
            throw new \Exception($this->statusStr[$bodyStr]);
        }
    }


    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function sendMosSms()
    {
        $this->init();

        $client = new \GuzzleHttp\Client(['base_uri' => $this->provider['smsmos']['url']]);

        $Authorization = base64_encode("{$this->provider['smsmos']['user']}:{$this->provider['smsmos']['pass']}");//1.使用Base64(用户名 + 冒号 + MD5(密码))

        $headers = [
            "Content-Type" => "application/json;charset=utf-8;",
            "Accept" => "application/json;",
            "Authorization" => "{$Authorization};"
        ];

        $data = [
            "batchName" => $this->content,
            "items" => [["to" => $this->phone]],
            "content" => $this->content,//短信内容
            "msgType" => "sms",
            "bizType" => 100,
        ];

        $response = $client->request("POST", '/api/v1.0.0/message/mass/send', [
            'headers' => $headers,
            'body' => json_encode($data)
        ]);

        $bodyStr = (string)$response->getBody();

        Log::info($bodyStr);

        if (!empty($bodyStr)) {
            $result = json_decode($bodyStr, true);
            if (intval($result['code']) === 0) {
                return true;
            } else {
                throw new \Exception($result['msg']);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function init()
    {
        if (empty($this->content)) {
            throw new \Exception('验证码为空');
        }
        if (empty($this->phone)) {
            throw new \Exception('手机号码为空');
        }
    }
}
