@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '' : Auth::user()->access_key !!}',
        puid: '{{ $sub_account['puid'] }}',
        sub_account:'{{  $sub_account['name']  }}',
        trans_charts: {!! json_encode($trans_charts) !!},
        trans_group: {!! json_encode($trans_group) !!},
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')
    <div class="main-body dashboard">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li>{{ trans('global.dashboard.dashboard') }}</li>
                </ol>
            </div>

            <div class="row dashInfo">

                <div class="db db-left">
                    <div class="db-header">
                        <i class="icon-info hashrate"></i>
                        <span>{{ trans('global.dashboard.realHashrate') }}</span>
                    </div>
                    <hr style="margin-top: 28px; margin-bottom: 25px;">

                    <div class="row db-body">
                        <div class="col-xs-4">
                            <div class="k">1{{ trans('global.dashboard.minute') }}</div>
                            <div class="v" v-cloak>
                                <span v-animate-num="shares_1m"></span>
                                <span class="unit">@{{ shares_unit | addHs }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="k">5{{ trans('global.dashboard.minute') }}</div>
                            <div class="v" v-cloak>
                                <span v-animate-num="shares_5m"></span>
                                <span class="unit">@{{ shares_unit | addHs }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4" >
                            <div class="k">15{{ trans('global.dashboard.minute') }}</div>
                            <div class="v" v-cloak>
                                <span v-animate-num="shares_15m"></span>
                                <span class="unit">@{{ shares_unit | addHs }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="db db-middle">
                    <div class="db-header">
                        <i class="icon-info miners"></i>
                        <span>{{ trans('global.dashboard.miners') }}</span>
                    </div>

                    <div class="row db-body">
                        <div class="col-xs-12 v" style="margin-bottom: 10px;" v-animate-num="workers_total" fixed="0"  v-cloak></div>

                        <div class="col-xs-6">
                            <div class="k">{{ trans('global.dashboard.active') }}</div>
                            <div class="v" style="font-size: 20px; color: #66bb44;"  v-cloak
                                 v-animate-num="workers_active" fixed="0"></div>
                        </div>

                        <div class="col-xs-6">
                            <div class="k">{{ trans('global.dashboard.inActive') }}</div>
                            <div class="v" style="font-size: 20px; color: #c30;"  v-cloak
                                 v-animate-num="workers_inactive" fixed="0"></div>
                        </div>
                    </div>
                </div>

                <div class="db db-right">
                    <div class="db-header">
                        <i class="icon-info earning"></i>
                        <span >{{ trans('global.dashboard.earning') }}</span>
                    </div>
                    <hr style="margin-top: 30px; margin-bottom: 25px;">
                    <div class="row db-body">
                        <div class="col-xs-6">
                            <div class="k">
                                {{ trans('global.dashboard.today') }}
                            </div>
                            <div class="v" style="font-size: 20px;"  v-cloak
                                v-animate-num="earnings_today" fixed="8"></div>
                        </div>
                        <div class="col-xs-6">
                            <div class="k" >
                               {{ trans('global.dashboard.yesterday') }}
                                <span class="instruction ins-all" data-toggle="tooltip" data-placement="bottom"
                                      data-original-title="{{trans('global.earn.yesterday')}}">
                                </span>
                            </div>
                            <div class="v" style="font-size: 20px;"  v-cloak
                                v-animate-num="earnings_yesterday" fixed="8"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hashRate">
                <div class="panel panel-bm" style="margin-bottom: 5px">
                    <div class="panel-heading">
                        <div class="panel-heading-title">
                            <span class="stats-title">{{ trans('global.dashboard.hastrateChart') }}</span>
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

            <div class="row minerGroup">

                <template v-for="item in groups.list | orderBy 'sort_id'" track-by="$index">
                    <div class="miner" v-if="Math.abs(item.gid)>0">
                        <div class="heading"> @{{ item.name  | name }}</div>
                        <div class="panel-body">
                            <div>
                                <span class="k">{{ trans('global.dashboard.nowHashrate') }}: </span>
                                <span class="v" style="color: #262626;padding-left: 3px">
                                    <span>@{{ item.shares_15m | fixed 2 }}</span>
                                    <span class="spanUnit">@{{ item.shares_unit | addHs }}</span>
                                </span>
                            </div>
                            <div>
                                <span class="k">{{ trans('global.dashboard.activeMiner') }}:</span>
                                <span class="v" style="color: #262626;padding-left: 3px">
                                    <span> @{{ item.workers_active }}</span>
                                    <span style="margin-left: -3px">/</span>
                                    <span style="margin-left: -2px">@{{ item.workers_total }}</span>
                                </span>
                            </div>
                            <a href="{{ route('miners') }}?id=@{{ item.gid }}">{{ trans('global.dashboard.more') }}</a>
                        </div>
                    </div>
                </template>


            </div>

            <div class="row minerStatus">
                <div class="col-xs-6 cox-left">
                    <div class="panel panel-bm ">
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span class="stats-title">{{ trans('global.dashboard.accountEarning') }}</span>
                                <a class="stats-info" href="{{route('history')}}">{{ trans('global.dashboard.more') }}</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <dl>
                                <dt>{{ trans('global.dashboard.unpaid') }}</dt>
                                <dd  v-cloak>@{{ income.unpaid | formatBlock}} BTC</dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.dashboard.amoutPaid') }}
                                    <a href="{{ route('history') }}" style="font-size: 12px;">{{ trans('global.dashboard.history') }}</a>
                                </dt>
                                <dd  v-cloak>@{{ income.total_paid | formatBlock }} BTC</dd>
                            </dl>
                            <hr/>
                            <dl>
                                <dt>{{ trans('global.dashboard.lastPaymentTime') }}</dt>
                                <dd  v-cloak>
                                    @{{ income.last_payment_time | formatTime  'pending' }}
                                </dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.dashboard.pendingPayouts') }}</dt>
                                <dd  v-cloak>
                                    @{{ income.pending_payouts | pending }}
                                    <span v-if="income.pending_payouts>0">BTC</span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 cox-right">
                    <div class="panel panel-bm ">
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span class="stats-title">{{ trans('global.dashboard.miningAddress') }}</span>
                                <a href="{{ route('help') }}" class="stats-info">{{ trans('global.dashboard.more') }}</a>
                            </div>
                        </div>
                        <div class="panel-body" style="height: 160px">
                            @foreach(json_decode(\DB::connection('global')->table('regions')->where('name', config('bitmain.region_name'))->first()['stratum_json'], true) as $config)
                                <div class="minerAddress">{{ $config }}</div>
                            @endforeach
                            <hr/>
                            <div>{!! trans('global.dashboard.minerName') !!} </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row minerStatus">
                <div class="col-xs-6 cox-left">
                    <div class="panel panel-bm ">
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span class="stats-title">{{ trans('global.dashboard.networkStatus') }}</span>
                                <a href="http://btc.com" class="stats-info" target="_blank">{{ trans('global.dashboard.more') }}</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <dl>
                                <dt>{{ trans('global.dashboard.networkHashrate') }}</dt>
                                <dd  v-cloak> @{{ networkStatus.network_hashrate | fixed 2}}
                                     @{{ networkStatus.network_hashrate_unit | addHs}}
                                </dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.dashboard.poolHashrate') }}</dt>
                                <dd  v-cloak>@{{ networkStatus.pool_hashrate | fixed 2 }}
                                    @{{ networkStatus.pool_hashrate_unit | addHs}}</dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.dashboard.miningEarnings') }}</dt>
                                <dd  v-cloak>1T * 24H = @{{ networkStatus.mining_earnings | fixed 4}} BTC =
                                    @{{ networkStatus.mining_earnings | rate}} </dd>
                            </dl>
                            <hr/>
                            <dl>
                                <dt>{{ trans('global.dashboard.nextDifficult') }}</dt>
                                <dd  v-cloak>
                                    @{{ networkStatus.difficulty_change }}
                                    (@{{ networkStatus.estimated_next_difficulty | diff 'value'}}
                                    @{{ networkStatus.estimated_next_difficulty | diff 'unit'}})
                                </dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.dashboard.timeRemain') }}</dt>
                                <dd  v-cloak>@{{ networkStatus.time_remain | formatTime  'remain' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 cox-right">
                    <div class="panel panel-bm ">
                        <div class="panel-heading">
                            <div class="panel-heading-title">
                                <span class="stats-title">{{ trans('global.dashboard.customer-title') }}</span>
                            </div>
                        </div>
                        <div class="panel-body">
                           {!! trans('global.dashboard.customer-table', ['feedback_link' => sprintf('https://bmfeedback.bitmain.com/feedback/app_feedback/?app=BTC_POOL&imei=1236456456&lan=%s',
                                                str_replace('-', '_', \App::getLocale()))])  !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer_script')
<script>
    require('modules/dashboard');
    $('.workerID').text(window.__btccom.sub_account);
    $('[data-toggle="tooltip"]').tooltip();
</script>
@endpush
