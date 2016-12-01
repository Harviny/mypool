@extends('sub-layout')

@push('header_script')
<script>
    window.__btccom = {
        ak: '{!! (is_null(Auth::user())) ? 0 : Auth::user()->access_key !!}',
        puid: '{{ ($sub_account) ? $sub_account['puid'] : '0'}}',
        node_list: {!! json_encode($node_list) !!},
        endpoint: {
            rest: '{!! config('bitmain.rest_api_endpoint') !!}',
            realtime: '{!! config('bitmain.rest2_api_endpoint') !!}'
        }
    };
</script>
@endpush

@section('body')
    <div class="main-body">
        <div class="container first-set">

            <div class="row" style="width:555px;margin:0 auto;">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">
                            <span>{{trans('global.first-set.create-worker')}}</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="step-panel">
                            <form @submit.prevent.stop="submit">
                                <div class="step" style="margin-bottom: 0">
                                    <span>{{trans('global.first-set.select-region')}}</span>
                                </div>
                                <div class="v" style="margin-top: 0" v-cloak>
                                    <a class="region-block" v-for="item in node_list"
                                       :class="check==item.region_name ? 'active': '' "
                                       v-on:click="setRegion(item.region_name)"
                                    >
                                        <span class="region-name" v-cloak>@{{ item.text }}</span>
                                    </a>
                                </div>
                                <div class="text-warning" v-if="error.nodeError" v-cloak>
                                    {{trans('global.first-set.no-node')}}
                                </div>
                                <div class="k">
                                    {{trans('global.first-set.region-ex')}}
                                </div>

                                <div class="step" style="margin-top: 30px">
                                    <span>{{trans('global.first-set.set-worker')}}</span>
                                </div>
                                <div class="v">
                                    <div class="form-group @{{ error.nameError=='' ? '' : 'has-error' }}">
                                        <input type="text" class="form-control input-auth" required
                                               v-model="worker_name"
                                               placeholder="{{ trans('global.first-set.enter-worker') }}"
                                               maxlength="20"
                                               title="{{ trans('global.first-set.verify-worker') }}"
                                               pattern="[a-zA-Z0-9]{3,20}$"
                                               onkeyup="changeTheWorker(this)"
                                        >
                                    </div>
                                    <div class="text-warning" v-if="error.nameError" v-cloak>
                                        @{{ error.nameError }}
                                    </div>
                                </div>
                                <div class="k">
                                    {!! trans('global.first-set.worker-ex') !!}
                                    {!! trans('global.first-set.worker-caution') !!}
                                </div>

                                <div class="step" style="margin-top: 30px">
                                    <span> {{trans('global.first-set.set-address')}}</span>
                                </div>
                                <div class="v">
                                    <div class="form-group @{{ error.addressError=='' ? '' : 'has-error' }}">
                                        <input type="text" class="form-control input-auth" required
                                               v-model="bitcoin_address"
                                               placeholder="{{ trans('global.first-set.enter-address') }}"
                                               style="width: 400px;">
                                    </div>
                                    <div class="text-warning" v-if="error.addressError" v-cloak>
                                        @{{ error.addressError }}
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-primary-small"
                                       value="{{trans('global.first-set.save')}}"  v-bind:disabled="loading">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('footer_script')
<script>
    const Vue = require('/modules/vue');
    const ajax = require('/modules/ajax');
    const workerID = $($('.workerID')[0]).text();

    function submitCreate() {
        var self = this;
        if (self.check == '') {
            self.error.nodeError = 'true';
            return;
        }
        self.loading=true;
        ajax.post(`${window.__btccom.endpoint.rest}/account/sub-account/create`,
                {
                    'region_node': self.check,
                    'worker_name': self.worker_name,
                    'bitcoin_address': self.bitcoin_address,
                })
                .then(function (data) {
                    self.loading=false;
                    if (data.err_no) {
                        if (data.err_msg.worker_name) {
                            self.error.nameError = data.err_msg.worker_name[0];
                        }
                        if (data.err_msg.bitcoin_address) {
                            self.error.addressError = data.err_msg.bitcoin_address;
                        }
                    } else {
                        if (data.status == true) {
                            window.location.href = data.region_base_url + '/region?access_key=' +
                                    window.__btccom.ak + '&puid=' + data.puid;
                        } else {
                            self.error.nameError = data.status;
                        }
                    }
                })
    }

    function changeTheWorker(self) {
        if (self.value){
            $('.workerID').text(self.value);
        }
        else{
            $('.workerID').text(workerID);
        }
    }

    new Vue({
        el: '.step-panel',
        data: {
            node_list: window.__btccom.node_list,
            check: '',
            worker_name: '',
            bitcoin_address: '',
            loading:false,
            error: {
                nodeError: '',
                nameError: '',
                addressError: '',
            }
        },
        filters: {},
        methods: {
            submit() {
                this.error = {nodeError: '', nameError: '', addressError: '',};
                submitCreate.call(this);
            },
            setRegion: function (node) {
                this.check = node;
            }
        },

    })


</script>
@endpush
