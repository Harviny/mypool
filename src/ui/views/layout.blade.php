<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <meta name="keywords" content="{{ $keywords or trans('global.meta.keywords') }}">
    <meta name="description" content="{{ $description or trans('global.meta.description') }}" />

    @stack('header_meta')

    <title>{{ $title or 'BTC.COM' }}</title>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="style/base.less" rel="stylesheet">
    @stack('header_style')
    @stack('header_script')
</head>
<body class="{{ $body_class or '' }}">

@include('include.header')

@yield('body')

@include('include.footer')

<script src="https://s.btc.com/common/js/selfxss/0.0.1/selfxss.min.js"></script>
<script src="mod.js"></script>
{!! app('fis')->useFramework() !!}

@stack('footer_script')
</body>
</html>