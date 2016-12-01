@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '0',
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        },
        sso: '{!! \BTCCOM\CAS\login_url(route('dashboard')) !!}',
        redirect: '{!! route('dashboard') !!}',
        trans_charts: {!! json_encode($trans_charts) !!},
    };
</script>
@endpush


@section('body')
    <div class="main-body">

        <div class="hero {{ 'hero' . random_int(1, 4) }}">
            <div class="container">
                <div class="row hero-container">
                    <div class="highlight">
                        <h1>{{ trans('global.index.newChoice') }}</h1>
                        <p><span class="fee">{!! trans('global.index.fee') !!} </span></p>
                        <p style="margin-top: 20px;"><span>{!! trans('global.index.subsidy') !!} </span></p>
                    </div>

                    <div class="login-box">
                        <style>
                            .login-box-loading {
                                width: 30px;
                                display: inline-block;
                                border: 3px solid #fff;
                                height: 30px;
                                border-top-color: transparent;
                                border-radius: 50%;
                                animation: rotate .7s linear infinite;
                            }

                            @keyframes rotate {
                                from {
                                    transform: rotate(0);
                                }
                                to {
                                    transform: rotate(360deg);
                                }
                            }
                        </style>
                        <div class="login-box-loading"></div>
                        <div class="login-box-links" style="display: none;">
                            <a class="btn-login login" href="{!! $login_url !!}">{{ trans('global.index.sign-in') }}</a>
                            <a class="btn-login"
                               href="{!! $register_url !!}">{{ trans('global.index.sign-up-now') }}</a>
                            {!! trans('global.index.customer-service') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hash">
            <div class="container">
                <div class="row">
                    <div class="panel panel-bm hashRate" style="margin-bottom: 0">
                        <div class="panel-heading">
                            <div class="panel-heading-title" v-cloak>
                                <div class="col-xs-6 text-center">
                                    <span class="v" v-animate-num="stats.shares.shares_15m" fixed="3"></span>
                                    <span class="k">@{{stats.shares.shares_unit | addHs }}</span>
                                    <span class="k">|</span>
                                    <span class="v" v-animate-num="stats.workers" fixed="0"></span>
                                    <span class="k"
                                          style="margin-right: 40px">{{ trans('global.index.workerOnline') }}</span>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <span class="k">{{ trans('global.index.found') }}:</span>
                                    <span class="v" v-animate-num="list.blocks_count" fixed="0"></span>
                                    <span class="k">{{ trans('global.index.blocks') }}</span>
                                    <span class="v" v-animate-num="rewards_count" fixed="0"></span>
                                    <span class="k">BTC</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-top: 0">
                            <div class="echart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app">
            <div class="container">
                <div class="row">
                    <div class="panel-body">
                        <div class="app-device">
                            <div id="app-phone"></div>
                            <div id="app-img"></div>
                        </div>
                        <div class="app-download">
                            <p>{{ trans('global.index.pool-app') }}</p>
                            <ul>
                                <li>{{ trans('global.index.pool-real-time') }}</li>
                                <li>{{ trans('global.index.pool-opeation') }}</li>
                                <li>{{ trans('global.index.pool-comming') }}</li>
                            </ul>
                            <div class="app-code"></div>
                            <a class="click-download" href="" target="_blank">{{ trans('global.index.pool-downlaod') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="leader-technology">
            <div class="container">
                <div class="row">
                    <div class="panel-body">
                        <p>{{ trans('global.index.cutting-edge-technology') }}</p>
                        <ul id="leader-ul">
                            <li>
                                <div class="icon"></div>
                                <span>{!! trans('global.index.latest-architecture') !!}</span>
                            </li>
                            <li>
                                <div class="icon"></div>
                                <span>{!! trans('global.index.open-source-code') !!} </span>
                            </li>
                            <li>
                                <div class="icon"></div>
                                <span>{!! trans('global.index.high-test-pressure') !!}</span>
                            </li>
                            <li>
                                <div class="icon"></div>
                                <span>{!! trans('global.index.low-orphaned-rate') !!}</span>
                            </li>
                            <li>
                                <div class="icon"></div>
                                <span>{!! trans('global.index.transparent-agent') !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="standard">
            <div class="container">
                <div class="row">
                    <div class="panel-body">
                        <p>{{ trans('global.index.standards-services') }}</p>
                        <div class="col-xs-4">
                            <div id="stand-phone" class="stand-phone">
                                <div id="telImg"></div>
                            </div>
                            <div class="custom-tel">
                                <span>{{ trans('global.index.customer-hotline') }}</span>
                                <span>400-890-8855</span>
                            </div>
                            <div class="custom-tel custom-tel-en">
                                <span>{{ trans('global.index.high-hashrate-consultation') }}</span>
                                <span>186-1283-5999</span>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <ul>
                                <li>{{ trans('global.index.professional-customer-service') }}</li>
                                <li>{{ trans('global.index.best-vip-server') }}</li>
                                <li>{{ trans('global.index.one-to-one') }}</li>
                            </ul>
                            <ul>
                                <li>{{ trans('global.index.app-available') }}</li>
                                <li>{{ trans('global.index.earnings-timely-everyday') }}</li>
                                <li>{{ trans('global.index.transnational-team-operation') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('footer_script')
<script>
    require('modules/index/index');
    $("[data-toggle='popover']").popover();
    var Di = 0, Ti = 0,Pi=0;

    window.onscroll = function () {
        var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
        var cHeight=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;
        var devices = document.getElementsByClassName('app-device')[0];
        var technology = document.getElementsByClassName('leader-technology')[0];
        var standard=document.getElementsByClassName('standard')[0];
        if (scrollTop>(devices.offsetTop-cHeight+200) && Di==0) {
            Di++;
            $('#app-phone').addClass("app-phone pt-page-moveFromBottomFade pt-page-delay180");
            $('#app-img').addClass("app-img pt-page-moveFromBottomFade pt-page-delay400");
        }
        if (scrollTop>(standard.offsetTop-cHeight+200) && Pi==0) {
            Pi++;
            $('#stand-phone').addClass("st-jump");
            $('#telImg').addClass("tel-img");
        }
        if (scrollTop>(technology.offsetTop-cHeight+200) && Ti == 0) {
            Ti++;
            var rowIndex=0
            $('#leader-ul>li>div').each(function () {
                rowIndex++;
                $(this).addClass(`icon-0${rowIndex} pt-page-moveFromBottomFade pt-page-delay${(rowIndex+2) * 100}`);

            })
        }


    }

    var linkSave = document.getElementsByClassName('click-download')[0];
    if (userAgent() == 'iOS') {
        linkSave.href = 'https://itunes.apple.com/cn/app/btc-pool-better-mining-pool/id1140021446';
    }
    else {
        linkSave.href = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.btc.pool';
    }

    $.getJSON(`${window.__btccom.sso}&callback=?`).then(response => {
        if (response.err_no == 0 && response.data.auth
    )
    {
        location.href = window.__btccom.redirect;
    }
    else
    {
        $('.login-box-loading').hide();
        $('.login-box-links').show();
    }
    })
    ;

</script>
@endpush