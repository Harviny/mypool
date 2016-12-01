<footer class="footer">
    <div class="container">
        <div class="row">

            <section >
                <p>{{ trans('global.common.footer.keep-touch') }}</p>
                <span>{{ trans('global.common.footer.social-network') }}</span>
                <div class="icon-panel">
                    <a href="https://twitter.com/btccom_official/" target="_blank"></a>
                    <a href="https://www.facebook.com/btccom/"  target="_blank"></a>
                    <a href="http://weibo.com/u/5995599784"  target="_blank"></a>
                    <a href="https://github.com/btccom/btcpool"  target="_blank"></a>
                </div>
                <span>{{ trans('global.common.footer.services') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#FAQ" target="_blank">{{ trans('global.common.footer.Help&faq') }}</a></li>
                    <li><a href="http://support.bitmain.com/" target="_blank">{{ trans('global.common.footer.ticket-system') }}</a></li>
                    <li><a href="{{ sprintf('https://bmfeedback.bitmain.com/feedback/app_feedback/?app=BTC_POOL&imei=1236456456&lan=%s',
                                                str_replace('-', '_', \App::getLocale())) }}" target="_blank">{{ trans('global.common.footer.Feedback') }}</a></li>
                    <li><span>{{ trans('global.common.footer.Phone') }}: +86-400-890-8855</span></li>
                </ul>
                <div class="icon-panel icon-panel2" style="position: relative">
                    <a href="https://telegram.me/btccom"  target="_blank"></a>
                    <a target="_blank" data-toggle="tooltip" onmouseover="$('.weixin').show()" onmouseout="$('.weixin').hide()"></a>
                    <div class="weixin"></div>
                </div>
            </section>

            <section>
                <p>{{ trans('global.common.footer.about-btccom') }}</p>
                <span>{{ trans('global.common.footer.about-us') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#aboutBtccom" target="_blank">{{ trans('global.common.footer.what-btccom') }}</a></li>
                    <li><a href="{{ route('help') }}#technical" target="_blank">{{ trans('global.common.footer.features') }}</a></li>
                    <li><a href="{{ route('help') }}#service" target="_blank">{{ trans('global.common.footer.btc-Services') }}</a></li>
                </ul>
                <a href="https://btc.com" class="block-chain" style="margin-top: 15px;" target="_blank">{{ trans('global.common.footer.blockchain') }}</a>
                <a href="https://pool.btc.com" class="block-chain" target="_blank">{{ trans('global.common.footer.btc-pool') }}</a>
                <a href="https://wallet.btc.com" class="block-chain" target="_blank">{{ trans('global.common.footer.Wallet') }}</a>
                <a href="https://btc.com/applications/app" class="block-chain" target="_blank">{{ trans('global.common.footer.app') }}</a>
                <a href="https://btc.com/api-doc" class="block-chain" target="_blank">API</a>
            </section>

            <section>
                <p>{{ trans('global.common.footer.pool-faqs') }}</p>
                <span>{{ trans('global.common.footer.create-account') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#not-receive-email" target="_blank">{{ trans('global.common.footer.not-receive-email') }}</a></li>
                    <li><a href="{{ route('help') }}#minerSet" target="_blank">{{ trans('global.common.footer.what-sub-account') }}</a></li>
                    <li><a href="{{ route('help') }}#aboutRegions" target="_blank">{{ trans('global.common.footer.mining-regions') }}</a></li>
                    <li><a href="{{ route('help') }}#getWallet" target="_blank">{{ trans('global.common.footer.get-wallet') }}</a></li>
                </ul>

                <span>{{ trans('global.common.footer.skill') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#alertEvents" target="_blank">{{ trans('global.common.footer.set-events') }}</a></li>
                    <li><a href="{{ route('help') }}#setWatchers" target="_blank">{{ trans('global.common.footer.set-watchers') }}</a></li>
                    <li><a href="{{ route('help') }}#registerVip" target="_blank">{{ trans('global.common.footer.regist-vip-server') }}</a></li>
                </ul>

            </section>

            <section>
                <p></p>
                <span>{{ trans('global.common.footer.start-mining') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#buyMiner" target="_blank">{{ trans('global.common.footer.get-miner') }}</a></li>
                    <li><a href="{{ route('help') }}#connectPool" target="_blank">{{ trans('global.common.footer.connect-pool') }}</a></li>
                    <li><a href="{{ route('help') }}#miners-no-stable" target="_blank">{{ trans('global.common.footer.stable') }}</a></li>
                    <li><a href="{{ route('help') }}#buildFarm" target="_blank">{{ trans('global.common.footer.build-farm') }}</a></li>
                </ul>

                <span>{{ trans('global.common.footer.about-bitcoin') }}</span>
                <ul>
                    <li><a href="{{ route('help') }}#rejection" target="_blank">{{ trans('global.common.footer.rejection-share') }}</a></li>
                    <li><a href="{{ route('help') }}#profit" target="_blank">{{ trans('global.common.footer.profit') }}</a></li>
                    <li><a href="{{ route('help') }}#TXfee" target="_blank">{{ trans('global.common.footer.fee') }}</a></li>
                    <li><a href="{{ route('help') }}#whatpps" target="_blank">{{ trans('global.common.footer.what-pps') }}</a></li>
                </ul>

            </section>

            <section >
                <div class="lang">
                    <div class="lang-active">
                        <a href="javascript:" data-toggle="dropdown">
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
                <div class="btc-app-code">
                    <a class="btc-pool-title" href="" target="_blank">
                        <span>BTC Pool App</span>&nbsp;
                        <span class="glyphicon glyphicon-save"></span>
                    </a>
                    @if(config('app.debug'))
                        <img src="/images/qr-code-dev@2x.png" style="width:135px; margin-top:5px;"/>
                    @else
                        <img src="/images/img_footer_App.png" style="width:135px; margin-top:5px;"/>
                        {{--<div class="btc-pool-app"></div>--}}
                    @endif

                </div>
                @push('footer_script')
                <script type="text/javascript">

                    var download = document.getElementsByClassName('btc-pool-title')[0];
                    if (userAgent() == 'iOS') {
                        download.href = 'https://itunes.apple.com/cn/app/btc-pool-better-mining-pool/id1140021446';
                    }
                    else {
                        download.href = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.btc.pool';
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
            </section>

        </div>
    </div>
</footer>