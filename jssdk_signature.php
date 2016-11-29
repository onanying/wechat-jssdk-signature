<?php

/**
 * 生成JS-SDK权限验证的签名
 * @author 刘健 <59208859@qq.com>
 */

// 引用文件
include 'autoload.php';
include 'config.php';

// 参数效验
$noncestr = isset($_GET["noncestr"]) ? $_GET["noncestr"] : null;
$timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : null;
$url = isset($_GET["url"]) ? $_GET["url"] : null;
if (is_null($noncestr) || is_null($timestamp) || is_null($url)) {
    die('params noncestr,timestamp,url not null');
}

// 签名计算
$wechat = Core\Wechat::jsapiTicket();
$urlArr = array(
    'noncestr=' . $noncestr,
    'timestamp=' . $timestamp,
    'url=' . $url,
    'jsapi_ticket=' . $wechat->ticket,
);
sort($urlArr, SORT_STRING);
$signature = implode('&', $urlArr);
$signature = sha1($signature);

// 输出
$output = array(
    'noncestr' => $noncestr,
    'timestamp' => $timestamp,
    'signature' => $signature,
);
// jsonp自适应
if (!empty($_GET['callbak'])) {
    echo $_GET['callbak'] . '(' . json_encode($output) . ')'; // jsonp
} else {
    echo json_encode($output); // json
}
