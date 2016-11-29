
// 用户配置
var appId = '****************';
var baseUrl = 'http://www.****.com/'; // jssdk_signature.php所在目录的URL
var jsApiList = ['getLocation', 'chooseWXPay', 'openLocation']; // 微信JS接口列表

// 随机字符串
function nonceStr(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for (var i = 0; i < 16; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

// 签名参数
var nonceStr = nonceStr();
var timestamp = parseInt(new Date().getTime()/1000);
var url = window.location.href.replace(window.location.hash, "");

// 获取签名
$.getJSON(baseUrl + "jssdk_signature.php?noncestr=" + nonceStr + "&timestamp=" + timestamp + "&url=" + url + "&callbak=?", function(json){
    // 配置JS-SDK
    wx.config({
        debug: false,
        appId: appId,
        timestamp: json.timestamp,
        nonceStr: json.noncestr,
        signature: json.signature,
        jsApiList: jsApiList
    });
});
