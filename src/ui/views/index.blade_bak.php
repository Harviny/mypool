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
        <div class="hero">
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
                            <a class="btn-login" href="{!! $register_url !!}">{{ trans('global.index.sign-up-now') }}</a>
                            <a class="btn-login" href="{!! $login_url !!}" style="margin-top: 15px;">{{ trans('global.index.sign-in') }}</a>
                            {!! trans('global.index.customer-service') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="panel panel-bm hashRate" style="margin-bottom: 0">
                    <div class="panel-heading">
                        <div class="panel-heading-title" v-cloak>
                            <span class="stats-title">{{ trans('global.index.hashrate') }}</span>
                        </div>
                    </div>
                    <div class="panel-body" style="padding-top: 0">
                        <div class="pool-info" v-cloak>
                            <div class="stats">
                                <span class="v" v-animate-num="stats.shares.shares_15m" fixed="3"></span>
                                <span class="k">@{{stats.shares.shares_unit | addHs }}</span>
                                <span class="k">|</span>
                                <span class="v" v-animate-num="stats.workers" fixed="0"></span>
                                <span class="k" style="margin-right: 40px">{{ trans('global.index.workerOnline') }}</span>

                                <span class="k">{{ trans('global.index.found') }}:</span>
                                <span class="v" v-animate-num="list.blocks_count" fixed="0"></span>
                                <span class="k">{{ trans('global.index.blocks') }}</span>
                                <span class="v" v-animate-num="rewards_count" fixed="0"></span>
                                <span class="k">BTC</span>
                            </div>
                        </div>
                        <div class="echart"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('footer_script')
<script>
    require('modules/index/index');

    const $ = require('jquery');

    $.getJSON(`${window.__btccom.sso}&callback=?`).then(response => {
        if (response.err_no == 0 && response.data.auth) {
            location.href = window.__btccom.redirect;
        } else {
            $('.login-box-loading').hide();
            $('.login-box-links').show();
        }
    });
</script>
@endpush