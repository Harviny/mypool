@extends('admin.admin-layout')

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

        <div class="server-list" style="margin-top: 20px">
            <table class="table table-striped table-hover">
                <tr>
                    <td>服务器名</td>
                    <td>服务器ip</td>
                    <td>vip数量(子账户)</td>
                    <td>服务器创建时间</td>
                    <td>
                        管理
                        <button class="btn btn-sm" data-toggle="modal"
                                v-on:click="show_vip_server_info({
                                    'name': '',
                                    'ip': '',
                                }, 'create')"
                                data-target="#VipServerInfo">添加
                        </button>
                    </td>
                </tr>
                <tr v-for="server in server_list">
                    <td>@{{ server.name }}</td>
                    <td> @{{ server.ip }}</td>
                    <td> @{{ server.cnt }}</td>
                    <td> @{{ server.created_at }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                v-on:click="show_vip_server_info({
                                    'id': server.id,
                                }, 'delete')"
                                data-target="#VipServerInfo">删除</button>

                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                v-on:click="show_vip_server_info({
                                    'id': server.id,
                                    'name': server.name,
                                    'ip': server.ip,
                                    'cnt': server.cnt,
                                    'created_at': server.created_at,
                                }, 'update')"
                                data-target="#VipServerInfo">更新
                        </button>

                        <button class="btn btn-sm" data-toggle="modal"
                                v-on:click="show_add_vip_user_form(server.id)"
                                data-target="#addVipUser">添加用户
                        </button>
                    </td>
                </tr>
            </table>

            <!-- S: vip server info Modal -->
            <div class="modal fade" id="VipServerInfo" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                <span v-if="server_info_operation=='create'">创建 vip 服务器信息</span>
                                <span v-if="server_info_operation=='update'">更新 vip 服务器信息</span>
                                <span v-if="server_info_operation=='delete'">删除 vip 服务器信息</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{--vip 服务器创建表单--}}
                            <template v-if="server_info_operation=='create'">
                                <table class="table">
                                    <tr>
                                        <td>服务器名</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.name"></td>
                                    </tr>
                                    <tr>
                                        <td>服务器ip</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.ip"></td>
                                    </tr>
                                </table>
                            </template>

                            {{--vip 服务器删除表单--}}
                            <template v-if="server_info_operation=='delete'">
                                <span>此操作将删除该服务器信息，及该服务器下所有子帐户vip资格</span>
                            </template>

                             {{--vip 服务器更新表单--}}
                            <template v-if="server_info_operation=='update'">
                                <input class="form-control" type="hidden" v-model="server_info_form.id">
                                <table class="table">
                                    <tr>
                                        <td>服务器名</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.name"></td>
                                    </tr>
                                    <tr>
                                        <td>服务器ip</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.ip"></td>
                                    </tr>
                                    <tr>
                                        <td>vip数量</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.cnt" readonly></td>
                                    </tr>
                                    <tr>
                                        <td>创建时间</td>
                                        <td><input class="form-control" type="text" v-model="server_info_form.created_at" readonly></td>
                                    </tr>
                                </table>
                            </template>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                            <template v-if="server_info_operation=='update'">
                                <button type="button" class="btn btn-primary" v-on:click="update_vip_server_info">保存</button>
                            </template>

                            <template v-if="server_info_operation=='create'">
                                <button type="button" class="btn btn-primary" v-on:click="add_vip_server">创建</button>
                            </template>

                            <template v-if="server_info_operation=='delete'">
                                <button type="button" class="btn btn-primary" v-on:click="delete_vip_server">删除</button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <!-- E: vip server info Modal -->

            <!-- S: add vip user -->
            <div class="modal fade" id="addVipUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">添加vip用户</h4>
                        </div>
                        <div class="modal-body">
                            <template v-if="vip_user_operation=='search'">
                                <input type="hidden" v-model="vip_user_server_id">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" placeholder="用户uid"
                                                   v-model="search_vip_user_uid">
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" v-on:click="search_vip_puid">
                                                搜索子账户
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </template>

                            <template v-if="vip_user_operation=='show'">
                                <div class="checkbox" v-for="subaccount in search_vip_user_subaccount">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="@{{ subaccount.puid }}" v-model="add_vip_puid_list">
                                            <span>@{{ subaccount.puid }} : @{{ subaccount.name }}</span>
                                        </label>
                                    </div>
                                </div>
                            </template>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                            <template v-if="vip_user_operation=='show'">
                                <button type="button" class="btn btn-primary" v-on:click="add_vip_account">
                                    添加
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <!-- E: add vip user -->

        </div>

        <div class="vip-list">
            <table class="table table-striped table-hover">
                <tr>
                    <td>服务器名</td>
                    <td>uid</td>
                    <td>puid</td>
                    <td>子帐户</td>
                    <td>
                        算力[
                        <button class="btn btn-sm" v-bind:class="(hashrate_dimension == 'day') ? 'btn-primary' : ''"
                                v-on:click="change_vip_user_list_dimension('day')">日</button>
                        <button class="btn btn-sm" v-bind:class="(hashrate_dimension == 'hour') ? 'btn-primary' : ''"
                                v-on:click="change_vip_user_list_dimension('hour')">时</button>
                        ]
                    </td>
                    <td>矿机数量(活跃/全部)</td>
                    <td>联系方式</td>
                    <td>备注</td>
                    <td>控制面板</td>
                </tr>
                <tr v-for="sub_account in vip_user_list">
                    <td>@{{ sub_account.vip_server_name }}</td>
                    <td>@{{ sub_account.uid }}</td>
                    <td>@{{ sub_account.puid }}</td>
                    <td>@{{ sub_account.name }}</td>
                    <td>@{{ sub_account.hashrate.size}} @{{ sub_account.hashrate.unit}}</td>
                    <td>@{{ sub_account.active_cnt}} / @{{ sub_account.all_cnt}}</td>
                    <td>
                        <button class="btn btn-sm" v-on:click="show_user_contact_info(sub_account.uid)"
                                data-toggle="modal" data-target=".showSubaccountContactInfo">联系用户</button>
                    </td>
                    <td align="right">
                        <span class="text-right" title="@{{ sub_account.admin_note }}">@{{ sub_account.admin_note | breakLine '10'　}}</span>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".showSubaccountNote"
                                v-on:click="show_subaccount_note(sub_account.puid,sub_account.admin_note)">更新
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" v-on:click="sub_account_dashboard(sub_account.uid, sub_account.puid)">控制台</button>
                        <button class="btn btn-sm btn-primary" v-on:click="delete_vip(sub_account.puid)">取消vip</button>
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
    </div>
@endsection

@push('footer_script')
<script>
    const $ = require('jquery');
    require('bootstrap');
    const endpoint = window.__btccom.endpoint;
    require('modules/internal/admin/vip.js');
</script>
@endpush
