@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '' : Auth::user()->access_key !!}',
        puid: '{{ ($sub_account) ? $sub_account['puid'] : '0'}}',
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')

    <div class="main-body earning">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li>{{trans('global.earn.earn')}}</li>
                </ol>
            </div>

            <div class="row imported">
                <div class="col-xs-6 cox-left">
                    <div class="panel panel-bm ">
                        <div class="panel-body">
                            <dl>
                                <dt>{{trans('global.earn.paid')}}</dt>
                                <dd v-cloak>@{{ income.total_paid | formatBlock}} <span class="text-muted">BTC</span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>{{trans('global.earn.Unpaid')}}</dt>
                                <dd v-cloak>@{{ income.unpaid | formatBlock}} <span class="text-muted">BTC</span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 cox-right">
                    <div class="panel panel-bm ">
                        <div class="panel-body">
                            <dl>
                                <dt>{{trans('global.earn.EarningsToday')}}</dt>
                                <dd v-cloak>
                                    @{{ income.earnings_today | formatBlock}}
                                    <span class="text-muted">BTC</span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <span class="all">{{trans('global.earn.EarningsYesterday')}}</span>
                                    <span class="instruction ins-all" data-toggle="tooltip" data-placement="bottom"
                                          data-original-title="{{trans('global.earn.yesterday')}}">
                                    </span>
                                </dt>
                                <dd v-cloak>@{{ income.earnings_yesterday | formatBlock}}
                                    <span class="text-muted">BTC</span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-bm" style="margin-bottom: 20px;overflow: visible">
                    <div class="panel-body" v-cloak>

                        <div class="subsidy">
                            <div class="col-md-6" style="padding:0">
                                <span class="text-left" >
                                    <span style="float: left">{{trans('global.rebates.SubsidyCounting')}}</span>
                                    <span class="instruction" data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="{{trans('global.rebates.support')}}">
                                    </span>
                                </span>
                                <span class="text-right" style="padding-right:26px;">
                                    {!!  trans('global.rebates.DaysRemain')  !!}
                                </span>
                            </div>
                            <div class="col-md-6" style="padding:0">
                                <span class="text-left" style="padding-left:30px;">{{trans('global.rebates.AccumulatedProfit')}}</span>
                                <span class="text-right"> @{{ subsidy.status.amount  | formatBlock }}
                                    <span class="text-muted">BTC</span>
                                </span>
                            </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" v-bind:style="{width:subsidy.status.rebates_progress }"></div>
                            <div class="progress-bit"> @{{ subsidy.status.amount | formatBlock }}&nbsp;BTC</div>
                        </div>

                        <table class="table pool-table">
                            <thead>
                            <tr>
                                <th class="text-left">{{trans('global.rebates.time')}}</th>
                                <th class="text-right">{{trans('global.rebates.AverageHashrate')}}</th>
                                <th class="text-right">{{trans('global.rebates.ActiveTime')}}</th>
                                <th class="text-center">{{trans('global.rebates.Address')}}</th>
                                <th class="text-right">{{trans('global.rebates.Earnings')}}</th>
                            </tr>
                            </thead>
                            <tbody v-for="item in subsidy.history" track-by="$index"  style="border:0;">
                                <tr>
                                    <td class="text-left">@{{ item.start_day |formatTime}} {{trans('global.rebates.to')}} @{{ item.end_day | formatTime}}</td>
                                    <td class="text-right">@{{item.avg_hashrate}}</td>
                                    <td class="text-right">@{{item.day_count}} {{trans('global.rebates.days')}}</td>
                                    <td class="text-center"><a href="https://btc.com/@{{item.payment_address}}" target="_blank">@{{item.payment_address}}</a></td>
                                    <td class="text-right">@{{item.amount | formatBlock}} BTC</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-bm" style="margin-bottom: 0">
                    <div class="panel-body miner-table">
                        <table class="table table-hover pool-table">
                            <thead>
                            <tr>
                                <th>{{trans('global.earn.Time')}}</th>
                                <th style="text-align: right">{{trans('global.earn.NetworkDifficulty')}}</th>
                                <th style="text-align: right">{{trans('global.earn.Earnings')}}</th>
                                <th style="text-align: right">{{trans('global.earn.Payment')}}</th>
                                <th style="text-align: center">{{trans('global.earn.Mode')}}</th>
                                <th style="text-align: center">{{trans('global.earn.Address')}}</th>
                                <th style="text-align: right">{{trans('global.earn.PaidAmount')}}</th>
                            </tr>
                            </thead>
                            <tbody v-for="item in list.list" track-by="$index" style="border:0;"  v-cloak>
                                <tr>
                                    <td>@{{item.date | formatTime}}</td>
                                    <td style="text-align: right">@{{item.diff}}</td>
                                    <td style="text-align: right">@{{item.earnings | formatBlock }}</td>
                                    <td style="text-align: right">
                                        <span v-if="item.payment_time == 0">-</span>
                                        <a v-if="item.payment_time != 0" href="https://btc.com/@{{item.address}}" target="_blank">
                                            @{{ item.payment_time }}
                                        </a>
                                    </td>
                                    <td style="text-align: center">@{{item.payment_mode}}</td>
                                    <td style="text-align: center">
                                        <a href="https://btc.com/@{{item.address}}" target="_blank" class="eqfont">
                                            @{{item.address}}
                                        </a>
                                    </td>
                                    <td style="text-align: right">@{{item.paid_amount | formatBlock }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="page-nav" v-show="list.page_count>1" style="margin-top: 10px;">
                            <ul id="pagination" class="pagination-sm"></ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('footer_script')
<script>
    require('modules/earn/earn');
    require('/modules/lib/jquery.twbsPagination');
</script>
@endpush
