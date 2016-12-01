@extends('admin.admin-layout')

@push('header_style')
<style>
    .search-user-list {
        background-color: #f0f0f0;
    }
    .search-user-list:hover {
        color: blue;
    }
</style>
@endpush

@push('header_script')
<script>
    window.__btccom = {
        endpoint: {
            uc_endpoint: '{!! config('bitmain.uc_endpoint') !!}',
        },
    };
</script>
@endpush

@section('body')
    <div class="container">
        <div class="row adminIndex">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <table class="table">
                    <tr>
                        <td>
                            <select class="form-control" v-model="search_user_type">
                                <option value="email" selected="selected">邮件</option>
                                <option value="phone">手机</option>
                            </select>
                        </td>
                        <td>
                            <input class="form-control" type="text" v-model.trim="search_user_value"
                                   v-on:keyup.enter="getUIDForUC(search_user_type, search_user_value)">
                            <table class="table" v-if="search_user_list!=false">
                                <tr v-for="item in search_user_list" v-on:click="setSearchUser(item.uid)">
                                    <td class="search-user-list">@{{ item.value }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5 form-group">
                <table class="table">
                    <tr>
                        <td><input class="form-control" type="text" v-model.trim="account_value" placeholder="UID/ 子账户"></td>
                        <td>
                            <select class="form-control" v-model="account_type">
                                <option value="uid" selected="selected">uid</option>
                                <option value="sub_account">子账户</option>
                                <option value="puid">puid</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-control" type="text" placeholder="日期"
                                   v-model.trim="date_time_value" value="{{ date('Ymd') }}">
                        </td>
                        <td>
                            <select class="form-control" title="date_time_dimension" v-model="date_time_dimension">
                                <option value="day" selected="selected">天</option>
                                <option value="hour">小时</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <select class="form-control" title="order_type" v-model="order_type">
                                <option value="hashrate" selected="selected">算力</option>
                                <option value="hashrate_change">算力波动</option>
                                <option value="reject_rate">拒绝率</option>
                                <option value="created_at">创建时间</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" title="order_value" v-model="order_value">
                                <option value="desc" selected="selected">倒序</option>
                                <option value="asc">正序</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align: center">
                            <button class="btn btn-primary" v-on:click="update_sub_account_list_data">搜索</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" id="sub_account_list">
                <table class="table table-striped table-hover">
                    <tr>
                        <td>UID</td>
                        <td>PUID</td>
                        <td>子账户</td>
                        <td>算力</td>
                        <td>最高算力</td>
                        <td>算力波动(1/3/7)日</td>
                        <td>拒绝率</td>
                        <td>创建时间</td>
                        <td>vip</td>
                        <td>联系方式</td>
                        <td>备注</td>
                        <td>管理地址</td>
                    </tr>

                    <tr v-for="sub_account in sub_account_list">
                        <td>@{{ sub_account.uid }}</td>
                        <td>@{{ sub_account.puid }}</td>
                        <td>@{{ sub_account.name }}</td>
                        <td>@{{ sub_account.hashrate['size'] + sub_account.hashrate['unit']}}</td>
                        <td>@{{ sub_account.max_hashrate['size'] + sub_account.max_hashrate['unit']}}</td>
                        <td>@{{ sub_account.hashrate_change }}<br>
                            @{{ sub_account.hashrate_change3 }}<br>
                            @{{ sub_account.hashrate_change7 }}</td>
                        <td>@{{ sub_account.reject_rate }}</td>
                        <td>@{{ sub_account.created_at }}</td>
                        <td v-if="sub_account.is_vip != null">
                            √
                        <td v-else>
                            x
                        </td>
                        <td>
                            <button class="btn" v-on:click="show_user_contact_info(sub_account.uid)"
                                    data-toggle="modal" data-target=".showSubaccountContactInfo">联系用户</button>
                        </td>
                        <td>
                            <span title="@{{ sub_account.admin_note }}">@{{ sub_account.admin_note | breakLine '10'　}}</span>
                            <button class="btn btn-primary" data-toggle="modal" data-target=".showSubaccountNote"
                                    v-on:click="show_subaccount_note(sub_account.puid,sub_account.admin_note)">更新
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-primary" v-on:click="sub_account_dashboard(sub_account.uid, sub_account.puid)">控制台</button>
                        </td>
                    </tr>
                </table>

                <!-- 子帐户备注Modal -->
                <div class="modal fade showSubaccountNote"  tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">更新子帐户备注</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" v-model="sub_account_note_puid">
                                <textarea title="" id="" cols="35" rows="5" v-model="sub_account_note"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary"
                                        v-on:click="update_subaccount_note(sub_account_note_puid, sub_account_note)">
                                    保存
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 显示用户联系方式 Small modal -->
                <div class="modal fade showSubaccountContactInfo" tabindex="-1" role="dialog"
                     aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">用户联系方式</h4>
                            </div>
                            <div class="modal-body">
                                <span> 邮箱地址: @{{ sub_account_contact_info.email }}</span><br>
                                <span> 手机号码: @{{ sub_account_contact_info.phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
@endsection

@push('footer_script')
<script>
    const $ = require('jquery');
    require('bootstrap');
    const endpoint = window.__btccom.endpoint;
    require('modules/internal/admin');
</script>
@endpush
