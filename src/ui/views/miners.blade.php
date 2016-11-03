@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? '' : Auth::user()->access_key !!}',
        puid: '{{ $sub_account['puid'] }}',
        trans_group: {!! json_encode($trans_group) !!},
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')
    <div class="main-body miners">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.common.home') }}</a></li>
                    <li>{{ trans('global.miners.miners') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-xs-2 cox-left">
                    <div class="workGroup">
                        <ul>
                            <template v-for="item in groups.list | orderBy 'sort_id'" track-by="$index" v-cloak>
                                <li class="${fields.group== item.gid?  'active' : ''}"
                                    v-on:click="updateWorker(item.gid,undefined,'worker_name',1,undefined,1)"
                                >
                                    ${item.name | name }
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div class="operate">
                        <div class="addMiner mod" data-toggle="modal" data-target="#addGroup"
                             title="{{ trans('global.miners.addGroup') }}"
                             v-if="groups.total_count<24"
                             v-on:click="clear()"
                        >
                        </div>
                        <div class="removeMiner mod" data-toggle="modal" data-target="#delGroup"
                             title="{{ trans('global.miners.delGroup') }}"
                             v-if="fields.group>0"
                             v-on:click="clear()"
                        >
                        </div>
                    </div>
                </div>
                <div class="col-xs-10 cox-right">
                    <div class="panel panel-bm" style="background-color: #e6e9ee">
                        <ul class="panel-heading miner-worker" v-cloak >
                            <li class="${fields.status== 'all'?  'active' : ''}"
                                v-on:click="updateWorker(fields.group,'all','worker_name',1,undefined,1)">
                               <span class="all">
                                    <span>{{ trans('global.miners.all') }}</span>
                                   (<span>${currentGroup.workers_total}</span>)
                               </span>
                               <span class="instruction ins-all" data-toggle="tooltip" data-placement="bottom"
                                     data-original-title="{{ trans('global.miners.tip') }}">
                               </span>

                            </li>
                            <li class="${fields.status== 'active'?  'active' : ''}"
                                v-on:click="updateWorker(fields.group,'active','worker_name',1,undefined,1)">
                                <span>{{ trans('global.miners.active') }}</span>
                                (<span>${currentGroup.workers_active}</span>)
                            </li>
                            <li class="${fields.status== 'inactive'?  'active' : ''}"
                                v-on:click="updateWorker(fields.group,'inactive','worker_name',1,undefined,1)">
                                <span>{{ trans('global.miners.inactive') }}</span>
                                (<span>${currentGroup.workers_inactive}</span>)
                            </li>
                            <li class="${fields.status== 'dead'?  'active' : ''}"
                                v-on:click="updateWorker(fields.group,'dead','worker_name',1,undefined,1)">
                                <span>{{ trans('global.miners.dead') }}</span>
                                (<span>${currentGroup.workers_dead}</span>)
                            </li>
                            <li>
                                <span>{{ trans('global.miners.total') }}:</span>
                                <span>${currentGroup.shares_15m | fixed 2}</span>
                                <span>${currentGroup.shares_unit|addHs}</span>
                            </li>
                        </ul>
                        <div class="panel-body miner-table">
                            <table id="minerTB" class="table table-hover pool-table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="hashLeft workLeft"> {{ trans('global.miners.workerName') }}</div>
                                        <div class="hashLeft workLeft">
                                            <i class="sort-asc"
                                               v-on:click="updateWorker(fields.group,fields.status,'worker_name','1')"></i>
                                            <i class="sort-desc"
                                               v-on:click="updateWorker(fields.group,fields.status,'worker_name','0')"></i>
                                        </div>
                                    </th>
                                    <th style="text-align:right">
                                        <div class="hashLeft">
                                            <i class="sort-asc"
                                               v-on:click="updateWorker(fields.group,fields.status,'shares_15m','1')"></i>
                                            <i class="sort-desc"
                                               v-on:click="updateWorker(fields.group,fields.status,'shares_15m','0')"></i>
                                        </div>
                                        <div class="hashLeft">{{ trans('global.miners.Hashrate') }}</div>
                                    </th>
                                    <th style="text-align:right">{{ trans('global.miners.Accepted') }}</th>
                                    <th style="text-align:right">{{ trans('global.miners.Rejected') }}</th>
                                    <th style="text-align:center">
                                        <div class="last-share"> {{ trans('global.miners.LastShare') }} </div>
                                        <div class="hashLeft last-share-i">
                                            <i class="sort-asc"
                                               v-on:click="updateWorker(fields.group,fields.status,'last_share_time','1')"></i>
                                            <i class="sort-desc"
                                               v-on:click="updateWorker(fields.group,fields.status,'last_share_time','0')"></i>
                                        </div>

                                    </th>
                                    <th style="text-align: center">{{ trans('global.miners.Status') }}</th>
                                    <th style="text-align:right">
                                        <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropOperation" data-toggle="dropdown">
                                                    <span>{{ trans('global.miners.Operation') }}</span><span
                                                            class="caret"></span>
                                                </span>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropOperation">
                                                <li>
                                                    <span class="glyphicon glyphicon-move"></span>
                                                    <span>{{ trans('global.miners.moveTo') }}</span>
                                                </li>

                                                <li v-for="item in groups.list | orderBy 'sort_id'">

                                                    <a v-if="item.gid!=fields.group && Math.abs(item.gid)>0"
                                                       v-on:click="operateWorker(item.gid)" class="group-name">
                                                        ${item.name| name}
                                                    </a>
                                                </li>

                                                <li class="divider"></li>
                                                <li>
                                                    <a v-on:click="operateWorker(0)">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                        <span>{{ trans('global.miners.remove') }}</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody v-for="item in worker.data" track-by="$index" style="border:0;" v-cloak >
                                    <tr class="${item.checked ?  'bgChecked' : ''}">
                                        <td>
                                            <a href="{{route('miner')}}?id=${item.worker_id}">${item.worker_name}</a>
                                        </td>
                                        <td style="text-align:right">
                                            <span>${item.shares_15m | fixed 2}</span>
                                            <span>${item.shares_unit | addHs}</span>
                                        </td>
                                        <td style="text-align:right">${item.accept_count}</td>
                                        <td style="text-align:right">${item.reject_percent * 100 | fixed 2 }%</td>
                                        <td style="text-align:center">
                                            <span class="${item.status=='ACTIVE' ? 'normalColor' : 'badColor'}">
                                                ${item.last_share_time | formatTime}
                                            </span>
                                        </td>
                                        <td style="text-align:center">
                                            <span class="${item.status=='ACTIVE' ? 'normalBlock' : 'badBlock'}"></span>
                                        </td>
                                        <td style="text-align:right">
                                            <input type="checkbox" v-model="item.checked"
                                                   v-on:click="handleChecked()">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="no-miner" v-if="worker.total_count==0">{{ trans('global.miners.noMiner') }}</div>
                            <div class="page-nav" style=" height: 55px;" v-show="worker.total_count>0">
                                <ul id="pagination" class="pagination-sm" v-show="worker.page_count>1" ></ul>
                            </div>
                            <div class="selectAll checkbox" v-show="worker.total_count>1">
                                <label>{{ trans('global.miners.selectAll') }}
                                    <input id='stAll' type="checkbox" style="margin-left:10px">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- 模态框（Add Group） -->
            <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <span>{{ trans('global.miners.addGroup') }} </span>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="input-auth" placeholder="{{ trans('global.miners.groupName') }}"
                                   id="addGroupName"
                                   v-on:keyup.enter="operateGroup('create')">
                            <label class="v-error"></label>
                            <label class="v-success"></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-primary-small" v-on:click="operateGroup('create')">
                                {{ trans('global.miners.done') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <!-- 模态框（Del Group） -->
            <div class="modal fade" id="delGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <span>  {{ trans('global.miners.delGroupTitle') }}</span>
                        </div>
                        <div class="modal-body">
                            <span>{{ trans('global.miners.confirm') }}</span><br/>
                            <label class="v-error"></label>
                            <label class="v-success"></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-primary-small"
                                    v-on:click="operateGroup('delete',fields.group)">
                                {{ trans('global.miners.done') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <!-- 模态框（Del Group） -->
            <div class="modal fade messageTip" id="messageTip" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body messageInfo"></div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" aria-hidden="true" class="btn-primary-small">
                                {{trans('global.common.users.ok')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

        </div>
    </div>
@endsection

@push('footer_script')
<script>
    require('modules/miner/worker');
    require('/modules/lib/jquery.twbsPagination');
</script>
@endpush
