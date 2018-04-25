<?php
/**
 * Created by PhpStorm.
 * User: mayday_j
 * Date: 2018/4/24
 * Time: 下午3:58
 */

namespace App\Service;
use Log;

use Unirest\Request;

class NeteaseIMService
{
    const BASE_URL = 'https://api.netease.im/nimserver';

    protected $appKey;
    protected $appSecret;

    public function __construct($appKey, $appSecret)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function callApi($apiPath, $data)
    {
        ksort($data);
        $body = http_build_query($data);



        $nonce = '';
        $curTime = '';
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
            'AppKey' => $this->appKey,
            'Nonce' => $nonce,
            'CurTime' => $curTime,
            'CheckSum' => $this->checksum($nonce, $curTime)
        ];

        Request::timeout(2);

        try {
            $resp = Request::post(static::BASE_URL . $apiPath, $headers, $body);
            Log::info('Netease IM callApi:' . $apiPath, [
                'headers' => $headers,
                'body' => $body,
                'resp' => (array)$resp
            ]);
        } catch (\Exception $e) {
            Log::error('Netease Im callApi' . $apiPath . ' exception, e = ' . $e->getMessage());
            return false;
        }

        if (!$resp && $resp->code) {

        }

    }

    public function checksum($nonce, $curTime)
    {
        return sha1($this->appSecret . $nonce . $curTime);
    }
}