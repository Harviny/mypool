<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-xs-8 foot-left">
                <ul>
                    <li><a href="https://btc.com/" target="_blank">{{trans('global.common.footer.chain')}}</a></li>
                    <li><a href="https://btc.com/applications" target="_blank">{{trans('global.common.footer.app')}}</a>
                    </li>
                    <li><a href="https://btc.com/tools" target="_blank">{{trans('global.common.footer.tools')}}</a></li>
                    <li><a href="https://www.bitmaintech.com/about.htm"
                           target="_blank">{{trans('global.common.footer.About')}}</a></li>
                    <li><a href="https://btc.com/api-doc" target="_blank">{{trans('global.common.footer.api')}}</a></li>
                    <li><a href="{{ sprintf('https://bmfeedback.bitmain.com/feedback/app_feedback/?app=BTC_POOL&imei=1236456456&lan=%s',
                                                str_replace('-', '_', \App::getLocale())) }}" target="_blank">
                        {{trans('global.common.footer.feedback')}}
                    </a>
                    </li>
                    {{--@if(is_null(\Auth::user()))--}}
                    {{--
                    <li><a href="{{ route('help') }}">{{ trans('global.menu.help')}}</a></li>
                    --}}
                    {{--@endif--}}
                    <li class="icon"><a href="https://twitter.com/btccom_official/" class="twitter" target="_blank"></a>
                    </li>
                    <li class="icon"><a href="http://weibo.com/u/5995599784" class="sina" target="_blank"></a></li>
                    <li class="icon"><a href="https://www.facebook.com/btccom/" class="facebook"
                                        target="_blank"></a></li>
                    <li class="icon"><a href="https://github.com/btccom/btcpool" class="github" target="_blank"></a>
                    </li>
                </ul>
            </div>
            <div class="col-xs-4 foot-right">
                <div class="lang">
                    {{--{{ trans('global.common.language') }}--}}
                    <div class="lang-active">
                        <a href="javascript:" data-toggle="dropdown" onclick="getDistacnce()">
                            {{ trans('global.lang.' . \App::getLocale()) }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu lang-dropdown">
                            @foreach (config('bitmain.languages') as $lang)
                            <li class="lang-option {{ (\App::getLocale() == $lang) ? 'disabled' : ''}}">
                                @if($lang == \App::getLocale())
                                <a href="javascript:">{{ trans('global.lang.' . $lang) }}</a>
                                @else
                                <a href="javascript:"
                                   onclick="setLanguageCookie('{{ $lang }}')">{{ trans('global.lang.' . $lang) }}</a>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <ul>
                    <li style="position: relative" onmouseover="$('.app-code').show()"
                        onmouseout="$('.app-code').hide()">
                        <a target="_blank" class="pool-app">{{ trans('global.common.footer.pool-app') }}</a>
                        <div class="app-code">
                            @if(config('app.debug'))
                            <img src="/images/qr-code-dev@2x.png" style="width:100%;"/>
                            @else
                            <img src="/images/qr-code@2x.png" style="width:100%;"/>
                            @endif
                            <div class="devices">
                                <a id="link-save" href="" style="color:#fff;" target="_blank">
                                    <span>Android & iOS</span>&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-save"></span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            @push('footer_script')
            <script type="text/javascript">
                var linkSave = document.getElementById('link-save');
                if (userAgent() == 'iOS') {
                    linkSave.href='https://itunes.apple.com/cn/app/btc-pool-better-mining-pool/id1140021446';
                }
                else{
                    linkSave.href='http://a.app.qq.com/o/simple.jsp?pkgname=com.btc.pool';
                }

                function getDistacnce() {
                    var footer = document.getElementsByClassName('footer')[0];
                    var langDrop = document.getElementsByClassName('lang-dropdown')[0];
                    var dis = document.body.scrollHeight - footer.offsetTop;

                    if (dis <= 110) {
                        langDrop.style.top = '-68px'
                    }
                }
                function setCookie(cookieName, value, expireDays) {
                    var expireDate = new Date();
                    expireDate.setDate(expireDate.getDate() + expireDays);
                    document.cookie = cookieName + "=" + value + ((expireDays == null) ? "" :
                            ";expires=" + expireDate.toUTCString()) + ";path=/";
                }

                function setLanguageCookie(lang) {
                    setCookie('lang', lang, 30);
                    location.reload();
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

            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-66176065-22', 'auto');
                ga('send', 'pageview');

            </script>
            @endpush

        </div>
    </div>
</footer>