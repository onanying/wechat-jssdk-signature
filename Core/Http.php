<?php

namespace Core;

/**
 * http处理类
 * @author 刘健 <59208859@qq.com>
 */
class Http
{

    /**
     * http GET请求
     * @author 刘健 <59208859@qq.com>
     */
    public static function get($url, $settings = null)
    {
        return self::curl($url, 'GET', null, $settings);
    }

    /**
     * http POST请求
     * @author 刘健 <59208859@qq.com>
     */
    public static function post($url, $data, $settings = null)
    {
        return self::curl($url, 'POST', $data, $settings);
    }

    /**
     * http请求
     * @author 刘健 <59208859@qq.com>
     * 需要开启curl扩展
     */
    public static function curl($url, $type = 'GET', $data = null, $settings = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        is_null($data) or curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // $data为数组
        !isset($settings['timeout']) or curl_setopt($ch, CURLOPT_TIMEOUT, $settings['timeout']);
        $response = curl_exec($ch);
        if ($error = curl_error($ch)) {
            throw new Exception('http_curl error: ' . $error);
        }
        curl_close($ch);
        return empty($settings['rawdata']) ? json_decode($response) : $response;
    }

}
