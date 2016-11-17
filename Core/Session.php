<?php

namespace Core;

/**
 * 会话操作类
 * @author 刘健 <59208859@qq.com>
 */
class Session
{

    private static $appid = CONF_APP_ID;
    private static $secret = CONF_APP_SECRET;

    /**
     * 获取 access_token
     * @author 刘健 <59208859@qq.com>
     * @return stdClass
     */
    public static function accessToken()
    {
        $cache = Cache::get('access_token');
        if (empty($cache) || $cache->expires_timestamp < time()) {
            $response = Http::get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . self::$appid . '&secret=' . self::$secret);
            $data = json_decode($response);
            $data->expires_timestamp = time() + ($data->expires_in - 30);
            Cache::put('access_token', $data);
        } else {
            $data = $cache;
        }
        return $data;
    }

    /**
     * 获取 jsapi_ticket
     * @author 刘健 <59208859@qq.com>
     * @return stdClass
     */
    public static function jsapiTicket()
    {
        $cache = Cache::get('jsapi_ticket');
        if (empty($cache) || $cache->expires_timestamp < time()) {
            $tokenData = self::accessToken();
            $response = Http::get('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $tokenData->access_token . '&type=jsapi');
            $data = json_decode($response);
            $data->expires_timestamp = time() + ($data->expires_in - 30);
            Cache::put('jsapi_ticket', $data);
        } else {
            $data = $cache;
        }
        return $data;
    }

}
