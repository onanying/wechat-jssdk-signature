
// 用户配置
var appId = '****************';

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
$.getJSON("/jssdk_signature.php?noncestr=" + nonceStr + "&timestamp=" + timestamp + "&url=" + url, function(json){
    // 配置JS-SDK
    wx.config({
        debug: false,
        appId: appId,
        timestamp: json.timestamp,
        nonceStr: json.noncestr,
        signature: json.signature,
        jsApiList: ['getLocation', 'chooseWXPay']
    });
});
