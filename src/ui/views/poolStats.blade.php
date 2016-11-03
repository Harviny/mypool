@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '0' : Auth::user()->access_key !!}',
        puid: '{{ ($sub_account) ? $sub_account['puid'] : '0'}}',
        trans_charts: {!! json_encode($trans_charts) !!},
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')

    <div class="main-body poolStats">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li>{{ trans('global.poolStats.poolStats') }}</li>
                </ol>
            </div>

            <div class="row pool-import">
                <div class="col-xs-6 cox-left">
                    <div class="panel panel-bm ">
                        <div class="panel-body">
                            <dl>
                                <dt>{{ trans('global.poolStats.Hashrate') }}</dt>
                                <dd  v-cloak>
                                    <span>@{{ stats.shares.shares_15m }}</span>
                                    <span class="text-muted">@{{ stats.shares.shares_unit | addHs }}</span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.poolStats.Miners') }}</dt>
                                <dd  v-cloak><span>@{{ stats.workers }}</span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 cox-right">
                    <div class="panel panel-bm ">
                        <div class="panel-body">
                            <dl>
                                <dt>{{ trans('global.poolStats.Found') }}</dt>
                                <dd  v-cloak>
                                    <span>@{{ list.blocks_count }}</span>
                                    <span class="text-muted">{{ trans('global.poolStats.blocks') }}</span>
                                </dd>
                            </dl>
                            <dl>
                                <dt></dt>
                                <dd  v-cloak>
                                    <span>@{{ list.rewards_count | formatBlock}}</span>
                                    <span class="text-muted">BTC</span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hashRate">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">
                            <span class="stats-title">{{ trans('global.poolStats.HashrateChart') }}</span>
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

            <div class="row">
                <div class="panel panel-bm " style="margin-bottom: 0">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.poolStats.BlocksRelayed') }}</div>
                    </div>
                    <div class="panel-body miner-table">
                        <table class="table table-hover pool-table"  v-cloak>
                            <thead>
                            <tr>
                                <th>{{ trans('global.poolStats.Height') }}</th>
                                <th style="text-align: right">{{ trans('global.poolStats.time') }}</th>
                                <th style="text-align: center">{{ trans('global.poolStats.BlockHash') }}</th>
                                <th style="text-align: right">{{ trans('global.poolStats.Reward') }}</th>
                            </tr>
                            </thead>
                            <tbody v-for="item in list.blocks.data" track-by="$index" style="border:0;" v-cloak>
                                <tr>
                                    <td><a href="https://btc.com/@{{ item.height }}" target="_blank">@{{ item.height }}</a></td>
                                    <td style="text-align: right">@{{ item.created_at | formatTime }}</td>
                                    <td class="eqfont">
                                        <a href="https://btc.com/@{{ item.hash }}" target="_blank">@{{ item.hash }}</a>
                                    </td>
                                    <td style="text-align: right">@{{ item.rewards | formatBlock }} BTC</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="page-nav"  v-show="list.blocks.last_page>1" style="margin-top: 10px;">
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
    require('modules/poolStats/poolStats');
    require('modules/poolStats/chart');
    require('/modules/lib/jquery.twbsPagination');
</script>
@endpush
