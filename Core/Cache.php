<?php

namespace Core;

/**
 * 缓存类
 * @author 刘健 <59208859@qq.com>
 */
class Cache
{

    public static $cacheDir = 'Cache';

    /**
     * 获取缓存
     * @author 刘健 <59208859@qq.com>
     */
    public static function get($fileName)
    {
        $str = @file_get_contents(FC_PATH . self::$cacheDir . DIRECTORY_SEPARATOR . $fileName);
        return json_decode($str);
    }

    /**
     * 设置缓存
     * @author 刘健 <59208859@qq.com>
     */
    public static function put($fileName, $data)
    {
        file_put_contents(FC_PATH . self::$cacheDir . DIRECTORY_SEPARATOR . $fileName, json_encode($data));
    }

}
