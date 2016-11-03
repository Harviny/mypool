@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '' : Auth::user()->access_key !!}',
        puid: '{{ $sub_account['puid'] }}',
        trans_charts: {!! json_encode($trans_charts) !!},
        trans_miner: {!! json_encode($trans_miner) !!},
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')
    <div class="main-body miner">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li><a href="{{ route('miners') }}">{{ trans('global.miner.Miners') }}</a></li>
                    <li v-cloak>@{{ list.worker_name }}</li>
                </ol>
            </div>

            <div class="row dashInfo">

                <div class="db db-left">
                    <div class="db-header">
                        <i class="icon-info hashrate"></i>
                        <span>{{ trans('global.miner.Hashrate') }}</span>
                    </div>
                    <hr style="margin-top: 28px; margin-bottom: 25px;">

                    <div class="row db-body">
                        <div class="col-xs-4">
                            <div class="k">1{{ trans('global.miner.M') }}</div>
                            <div class="v"  v-cloak>
                                <span v-animate-num="list.shares_1m" fixed="2"></span>
                                <span class="unit">@{{ list.shares_unit | addHs }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="k">5{{ trans('global.miner.M') }}</div>
                            <div class="v"  v-cloak>
                                <span v-animate-num="list.shares_5m" fixed="2"></span>
                                <span class="unit">@{{ list.shares_unit | addHs }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="k">15{{ trans('global.miner.M') }}</div>
                            <div class="v"  v-cloak>
                                <span v-animate-num="list.shares_15m" fixed="2"></span>
                                <span class="unit">@{{ list.shares_unit | addHs }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="db db-right">
                    <div class="db-header">
                        <i class="icon-info run"></i>
                        <span>{{ trans('global.miner.RunningCondition') }}</span>
                    </div>
                    <hr style="margin-top: 30px; margin-bottom: 25px;">
                    <div class="row db-body">
                        <div class="col-xs-3">
                            <div class="k">{{ trans('global.miner.Rejected') }}</div>
                            <div class="v" style="font-size: 20px;" v-cloak>
                                <span v-animate-num="list.reject_percent" fixed="2"></span>
                                <span class="unit">%</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="k">{{ trans('global.miner.Status') }}</div>
                            <div class="v" style="font-size: 20px;" v-cloak>
                                <span>@{{ list.worker_status | stats }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="k">{{ trans('global.miner.LastShare') }}</div>
                            <div class="v" style="font-size: 20px;" v-cloak>
                                <span>@{{ list.last_share_time | formatTime }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="k">{{ trans('global.miner.LastShareIP') }}</div>
                            <div class="v" style="font-size: 20px;" v-cloak >
                                <span data-toggle="tooltip" data-placement="bottom" style="cursor:pointer"
                                      data-original-title="@{{ list.ip2location }}">
                                    @{{ list.last_share_ip  }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hashRate">
                <div class="panel panel-bm" style="margin-bottom: 0">
                    <div class="panel-heading">
                        <div class="panel-heading-title">
                            <span class="stats-title">{{ trans('global.miner.HashrateChart') }}</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="pool-panel-interval">
                            <ul id="pool-stats">
                                <li unit="d"><a>1{{ trans('global.common.d') }}</a></li>
                                <li class="active" unit="h"><a>1{{ trans('global.common.h') }}</a></li>
                            </ul>
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
    require('modules/miner/miner');
    require('modules/miner/chart')
    $('[data-toggle="tooltip"]').tooltip();
</script>
@endpush
