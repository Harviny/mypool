@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '0' : Auth::user()->access_key !!}',
        puid: '{{ ($sub_account) ? $sub_account['puid'] : '0'}}',
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush
@section('body')

    <div class="main-body support">
        <div class="container v-cloak">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li>{{ trans('global.help.help') }}</li>
                </ol>
            </div>

            <div class="row help-top"></div>
            <div class="row" style="background-color: #fff;border-radius: 4px;">
                <div id="scrollHelp" class="col-xs-3 cox-left">
                    <ul class="nav nav-support">
                        <li class="active"><a href="#Configurations">{{ trans('global.help.Configurations') }}</a></li>
                        <li><a href="#Set">{{ trans('global.help.setAddress') }}</a></li>
                        <li><a href="#Earnings">{{ trans('global.help.earnPayment') }}</a></li>
                        <li><a href="#About">{{ trans('global.help.aboutBitcoin') }}</a></li>
                        <li><a href="#FAQ">{{ trans('global.help.faq') }}</a></li>
                        <li><a href="#Custom">{{ trans('global.help.customer') }}</a></li>
                        <li><a href="#aboutBtccom">{{ trans('global.help.aboutBtccom') }}</a></li>
                        <li><a href="#technical">{{ trans('global.help.technical-features') }}</a></li>
                        <li><a href="#service">{{ trans('global.help.service') }}</a></li>
                    </ul>
                </div>
                <div class="col-xs-9 cox-right">
                    <div class="panel panel-bm" id="Configurations">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.Configurations') }}</div>
                        </div>
                        <div class="panel-body">
                            <p>{{ trans('global.help.beijingNode') }}</p>
                            <div>stratum+tcp://cn.ss.btc.com:3333</div>
                            <div>stratum+tcp://cn.ss.btc.com:443</div>
                            <div>stratum+tcp://cn.ss.btc.com:25</div>
                            <br>
                            <p>{{ trans('global.help.eastAmericaNode') }}</p>
                            <div>stratum+tcp://us.ss.btc.com:3333</div>
                            <div>stratum+tcp://us.ss.btc.com:443</div>
                            <div>stratum+tcp://us.ss.btc.com:25</div>
                            <br>
                            <p id="minerSet">{{ trans('global.help.minerSet') }}</p>
                            <div>{{ trans('global.help.formatWorkerID') }}</div>
                            <div>
                                {{ trans('global.help.exampleWorkerID') }}
                            </div>
                            <div>{{ trans('global.help.password') }}</div>
                        </div>
                    </div>

                    <div class="panel panel-bm" id="Set">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.setAddress') }}</div>
                        </div>
                        <div class="panel-body">
                            {!!  trans('global.help.pool-set') !!}
                            <p>{{ trans('global.help.setFind') }}</p>
                            @if (App::getLocale() == 'zh-cn')
                                <img src="/images/setAddress_cn.png" style="width:350px; margin-top: 10px;">
                            @else
                                <img src="/images/setAddress_en.png" style="width:350px; margin-top: 10px;">
                            @endif

                        </div>
                    </div>

                    <div class="panel panel-bm" id="Earnings">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.earnPayment') }}</div>
                        </div>
                        <div class="panel-body">
                            <p>{{ trans('global.help.paymentTime') }}</p>
                            <div>{{ trans('global.help.paymentEx') }}</div>
                            <p>{{ trans('global.help.OnPaymentTime') }}</p>
                            <div>
                                {{ trans('global.help.PaymentTimeEx') }}
                            </div>
                            <p> {{ trans('global.help.MiningMode') }}</p>
                            <div> {{ trans('global.help.MiningModeEx') }}</div>
                            <p>{{ trans('global.help.fees') }}</p>
                            <div>{{ trans('global.help.feesEx') }}</div>
                        </div>
                    </div>

                    <div class="panel panel-bm" id="About">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.aboutBitcoin') }}</div>
                        </div>
                        <div class="panel-body">
                            {!!  trans('global.help.BitcoinEx') !!}
                        </div>
                    </div>

                    <div class="panel panel-bm" id="FAQ">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.faq') }}</div>
                        </div>
                        <div class="panel-body">
                            {!!  trans('global.help.faqEx')  !!}
                        </div>
                    </div>

                    <div class="panel panel-bm" id="Custom">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.customer') }}</div>
                        </div>
                        <div class="panel-body">
                            {!! trans('global.help.QQGroup') !!}
                            <a href="{{ sprintf('https://bmfeedback.bitmain.com/feedback/app_feedback/?app=BTC_POOL&imei=1236456456&lan=%s',
                                                str_replace('-', '_', \App::getLocale())) }}"
                               target="_blank">{{ trans('global.help.feedback') }}</a>
                        </div>
                    </div>

                    <div class="panel panel-bm" id="aboutBtccom">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.aboutBtccom') }}</div>
                        </div>
                        <div class="panel-body">
                            {!! trans('global.help.btccom-express') !!}
                        </div>
                    </div>

                    <div class="panel panel-bm" id="technical">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.technical-features') }}</div>
                        </div>
                        <div class="panel-body">
                            {!! trans('global.help.technical-features-express') !!}
                        </div>
                    </div>

                    <div class="panel panel-bm" id="service">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.help.service') }}</div>
                        </div>
                        <div class="panel-body">
                            {!! trans('global.help.service-express') !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('footer_script')
<script>
    var $ = require('jquery')

    $(function () {
        $('body').scrollspy({target: '#scrollHelp', offset: 380});
        $('.nav-support>li>a').each(function () {
            $(this).click(function () {
                $(this).addClass('active')
                $(this).siblings().removeClass('active')
            })
        })
        var header = document.querySelector('.cox-left');
        var origOffsetY = header.offsetTop;

        function onScroll(e) {
            window.scrollY >= origOffsetY ? header.classList.add('sticky') : header.classList.remove('sticky');
            if ($(document).scrollTop() >= $(document).height() - $(window).height()-280) {
                header.classList.add('sticky-bottom')
            }else{
                header.classList.remove('sticky-bottom');
            }
        }

        document.addEventListener('scroll', onScroll);
    })

</script>
@endpush
