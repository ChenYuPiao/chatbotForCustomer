<?php
require '../vendor/autoload.php';
use GuzzleHttp\Client;


class TuringRobot
{
    const API = 'http://www.tuling123.com/openapi/api';
    private static $apiKey;
    private static $apiSecret;
    private static $timestamp;
    private static $iv = [0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00];

    /**
     * 图灵机器人
     *
     * @return void
     */
    public function __construct($apiKey, $apiSecret)
    {
        self::$apiKey = $apiKey;
        self::$apiSecret = $apiSecret;
        self::$timestamp = time();
    }

    /**
     * say
     *
     * @param  string $info   请求内容，编码方式为UTF-8
     * @param  string $userid 用户分配的唯一标志
     * @param  string $loc    位置信息，请求跟地理位置相关的内容时使用，编码方式UTF-8
     * @return string
     */
    public function say($info = '你好', $userid = '', $loc = '')
    {
        $param = [
        	'key' => self::$apiKey,
            'info' => $info,
            'userid' => $userid,
            'loc' => $loc,
        ];

        $params = [
            'key' => self::$apiKey,
            'timestamp' => self::$timestamp,
            'data' => self::encrypt($param),
        ];

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post(self::API, ['content-type' => 'application/json', 'body' => json_encode($params)], []);
            if ($response->getStatusCode() == 200) {
                $body=$response->getBody();
                //$data = json_decode($body, true);
                return $body;
            } else {
                return json_encode([
                    'code' => $response->getStatusCode(),
                    'text' => '图灵机器人 api 服务异常',
                ]);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return json_encode([
                    'code' => $e->getResponse()->getStatusCode(),
                    'text' => '图灵机器人 api 服务不可用',
                ]);
            }
        }
    }

    protected static function encrypt($param)
    {
        $keyParam = self::$apiSecret . self::$timestamp . self::$apiKey;
        $key = md5($keyParam);
        $str = json_encode($param);
        // PKCS5 padding
        $pad = 16 - (strlen($str) % 16);
        $str .= str_repeat(chr($pad), $pad);
        // 兼容 java md5 hash, api 太坑了, 用了两次 md5, 第二次还是hash
        $key = hash('md5', $key, true);
        $iv = implode(array_map("chr", self::$iv));;
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
        mcrypt_generic_init($td, $key, $iv);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }
}
