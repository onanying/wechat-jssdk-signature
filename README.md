## wechat-jssdk-signature

微信JSSDK服务端生成签名认证，包含后端PHP与前端JS的实现，后端缓存access_token、jsapi_ticket。

### 怎么安装

在你的项目建立一个公开目录，把上面的代码全部放进去，例如:

    http://www.****.com/wxjssdk/

### 配置开发者ID

打开 config.php 修改 CONF_APP_ID 与 CONF_APP_SECRET，不知道填什么？去你的公众平台去找吧！

```php
// 微信开发者ID
define('CONF_APP_ID', '****************');
define('CONF_APP_SECRET', '********************************');
```

打开 jssdk-config.js 修改 appId、baseUrl、jsApiList

```javascript
// 用户配置
var appId = '****************';
var baseUrl = 'http://www.****.com/wxjssdk/'; // jssdk_signature.php所在目录的URL
var jsApiList = ['getLocation', 'chooseWXPay', 'openLocation']; // 微信JS接口列表
```

### 使用范例 

打开 jssdk_example.html 里面有一个定位的范例

### 范例讲解

范例里有引用3个js文件：<br>
1. 第一个是jquery，如果你的项目有引用，可以去掉<br>
2. 微信的jssdk的库，不能动<br>
3. 我写好的jssdk配置文件，这样你就不需要每个页面去配置了

```javascript
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/jssdk-config.js"></script>
```

接下来就是直接执行微信的js接口了，是不是很简单很方便

```javascript
<script type="text/javascript">

    // 配置成功后执行
    wx.ready(function(){

        // 获取地理位置
        wx.getLocation({
            type: 'wgs84',
            success: function (res) {
                console.log(res);
                var latitude = res.latitude;
                var longitude = res.longitude;
                var speed = res.speed;
                var accuracy = res.accuracy;
                alert("latitude:" + latitude + " / latitude:" + longitude);
            }
        });

    });

</script>
```

### 注意安全

因为 access_token、jsapi_ticket 做的是文件缓存，存放在 Cache 目录里，所以不要让别人知道你的url了，不然别人可以直接下载，我还是建议大家存到redis,memcache里去，修改下Core目录的Cache类就可以了，很简单的。

### 微信挖的坑

微信的签名算法要提供调用页面的url，文档是这样写的

- url=http://mp.weixin.qq.com?params=value

看上面应该是支持带参数的page，但是和上面写的一样，竟然只支持一个get参数，也就是说下面这样的多个参数的page不支持，会报签名错误

- url=http://mp.weixin.qq.com?params1=value1&params2=value2

要传多个值，就只能自己想办法咯，比如

- url=http://mp.weixin.qq.com?params=value1,value2