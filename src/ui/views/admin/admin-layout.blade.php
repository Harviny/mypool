<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no" />

    @stack('header_meta')

    <title>{{ $title or 'BTC.COM' }}</title>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="/style/base.less" rel="stylesheet">

    @stack('header_style')
    @stack('header_script')

</head>
<body>

<div>
    <div class="container">
        <div class="row">
            <div class="logo">
                <div class="logo-inner">
                    <a href="{{ route('internal.admin') }}" class="text-hide logo-link"></a>
                    <h1 style="display: none;">BTC.COM 矿池</h1>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('body')


<script src="mod.js"></script>
{!! app('fis')->useFramework() !!}

@stack('footer_script')
</body>
</html>