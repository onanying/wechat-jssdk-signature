<?php

namespace Core;

/**
 * 自定义菜单类
 * @author 刘健 <59208859@qq.com>
 */
class Menu
{

    /**
     * 创建菜单
     */
    public static function create()
    {
        $wechat = Wechat::accessToken(); // 获取access_token
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$wechat->access_token}";
        return Http::post($url, CONF_MENU, ['rawdata' => true]);
    }

}
