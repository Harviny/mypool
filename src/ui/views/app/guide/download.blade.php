<!DOCTYPE html>

<html lang="{{ App::getLocale() }}" style="height:100%;width:100%;" class="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- QQ/UC Full screen-->
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <meta name="format-detection" content="telephone=no"/>
    <meta name="keywords" content="{{ $keywords or trans('global.meta.keywords') }}">
    <meta name="description" content="{{ $description or trans('global.meta.description') }}"/>

    @stack('header_meta')

    <title>{{ $title or 'BTC.COM' }}</title>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="style/base.less" rel="stylesheet">
    <link rel="stylesheet" href="/style/app.less">
    @stack('header_style')
    @stack('header_script')
</head>
<body style="min-width:100%; height:667px;background-color: #fff;">
<section class="download">
    <div class="title">{{ trans('global.download.btc-pool') }}</div>
    <div class="pool-logo"></div>
    <a class="btn-download">{{ trans('global.download.app-download') }}</a>
    <div class="version">{{ trans('global.download.version') }}</div>
</section>
</body>
<script>

    var btn = document.querySelector(".btn-download");
    var lang = document.querySelector(".html").lang
    if (~lang.indexOf('zh')) {
        lang = 'zh-cn';
    } else {
        lang = 'en';
    }

    btn.ontouchstart = function () {
        this.className = "btn-download active";
    }
    btn.ontouchend = function () {
        this.className = "btn-download";
    }
    btn.onclick = function () {
        if (is_weixin() && userAgent() == 'iOS') {
            if(lang=='zh-cn'){
                alert('请点击微信右上角按钮,然后弹出菜单中,点击在Safari中打开,即可安装');
            }else{
                alert('Tap the bottom on the top right of WeChat, then open in safari and install it');
            }

        }
        else if (is_weixin() && userAgent() == 'Android') {
            if(lang=='zh-cn'){
                alert('请点击微信右上角按钮,然后弹出菜单中,点击在浏览器中打开,即可安装');
            }else{
                alert('Tap the bottom on the top right of WeChat, then open in browser and install it');
            }

        }
        else{
            btn.setAttribute('href', 'https://pool.btc.com/app/latestver');
        }
    }


    //  设备 or 系统
    function is_weixin() {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;
        } else {
            return false;
        }
    }

    function userAgent() {
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //g
        var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if (isAndroid) {
            return 'Android';
        }
        if (isIOS) {
            return 'iOS';
        }
    }


</script>
</html>