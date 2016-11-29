<?php

namespace Core;

/**
 * 微信类
 * @author 刘健 <59208859@qq.com>
 */
class Wechat
{

    private static $appid = CONF_APP_ID;
    private static $secret = CONF_APP_SECRET;

    /**
     * 获取 access_token
     * @author 刘健 <59208859@qq.com>
     * @return stdClass {"access_token":"ACCESS_TOKEN","expires_in":7200,"expires_timestamp":1479797789}
     */
    public static function accessToken()
    {
        $cache = Cache::get('access_token');
        if (empty($cache) || $cache->expires_timestamp < time()) {
            $response = Http::get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . self::$appid . '&secret=' . self::$secret);
            $response->expires_timestamp = time() + ($response->expires_in - 30);
            Cache::put('access_token', $response);
            $data = $response;
        } else {
            $data = $cache;
        }
        return $data;
    }

    /**
     * 获取 jsapi_ticket
     * @author 刘健 <59208859@qq.com>
     * @return stdClass {"errcode":0,"errmsg":"ok","ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKdvsdshFKA","expires_in":7200,"expires_timestamp":1479797789}
     */
    public static function jsapiTicket()
    {
        $cache = Cache::get('jsapi_ticket');
        if (empty($cache) || $cache->expires_timestamp < time()) {
            $wechat = self::accessToken();
            $response = Http::get('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $wechat->access_token . '&type=jsapi');
            $response->expires_timestamp = time() + ($response->expires_in - 30);
            Cache::put('jsapi_ticket', $response);
            $data = $response;
        } else {
            $data = $cache;
        }
        return $data;
    }

    /**
     * 通过code换取网页授权access_token
     * @author 刘健 <59208859@qq.com>
     * @return stdClass {"access_token":"ACCESS_TOKEN","expires_in":7200,"refresh_token":"REFRESH_TOKEN","openid":"OPENID","scope":"SCOPE"}
     */
    public static function webAccessToken($code)
    {
        return Http::get('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$appid . '&secret=' . self::$secret . '&code=' . $code . '&grant_type=authorization_code');
    }

    /**
     * 通过openid获取用户基本信息
     * @author 刘健 <59208859@qq.com>
     * @return stdClass 返回说明:https://mp.weixin.qq.com/wiki/1/8a5ce6257f1d3b2afb20f83e72b72ce9.html
     */
    public static function userinfo($openid)
    {
        $wechat = self::accessToken();
        return Http::get('https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $wechat->access_token . '&openid=' . $openid . '&lang=zh_CN');
    }

}
