<?php

namespace Core;

/**
 * 消息接收类
 * @author 刘健 <59208859@qq.com>
 */
class Receive
{

    private static $token = CONF_TOKEN;

    /**
     * 接收并处理消息
     * @author 刘健 <59208859@qq.com>
     */
    public static function start()
    {
        if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; // 原始post数据，还未转化为变量
            if (!empty($postStr)) {
                $xml = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            }
        } else {
            echo self::verify();
        }
    }

    /**
     * 验证请求是否来自微信
     * @author 刘健 <59208859@qq.com>
     */
    private static function verify()
    {
        $signature = isset($_GET["signature"]) ? $_GET["signature"] : null;
        $timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : null;
        $nonce = isset($_GET["nonce"]) ? $_GET["nonce"] : null;
        $echostr = isset($_GET["echostr"]) ? $_GET["echostr"] : null;
        // 效验
        if (self::checkSignature($signature, $timestamp, $nonce)) {
            // 返回随机字符串
            return $echostr;
        } else {
            return 'verify failure';
        }
    }

    /**
     * 检测签名是否合法
     * @author 刘健 <59208859@qq.com>
     */
    private static function checkSignature($signature, $timestamp, $nonce)
    {
        $tmpArr = array(self::$token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}
