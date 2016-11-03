@extends('admin.admin-layout')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <p></p>
            </div>
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td><input type="text" id="account_value" placeholder="UID/ 子账户"></td>
                        <td>
                            <select title="account_type" id="account_type">
                                <option value="uid">uid</option>
                                <option value="sub_account">子账户</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><input type="text" id="date_time_value" placeholder="日期"></td>
                        <td>
                            <select title="date_time_dimension" id="date_time_dimension">
                                <option value="day">天</option>
                                <option value="hour">小时</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <select title="order_type" id="order_type">
                                <option value="hashrate">算力</option>
                                <option value="hashrate_change">算力波动</option>
                                <option value="reject_rate">拒绝率</option>
                                <option value="created_at">创建时间</option>
                            </select>
                        </td>
                        <td>
                            <select title="order_value" id="order_value">
                                <option value="asc">正序</option>
                                <option value="desc">倒序</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align: center"><button id="sub_account_search">搜索</button></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table" id="sub_account_list">
                    <tr>
                        <td>UID</td>
                        <td>PUID</td>
                        <td>子账户</td>
                        <td>算力</td>
                        <td>算力波动</td>
                        <td>拒绝率</td>
                        <td>创建时间</td>
                        <td>管理地址</td>
                    </tr>

                    <tr v-for="sub_account in sub_account_list">
                        <td>@{{ sub_account.uid }}</td>
                        <td>@{{ sub_account.puid }}</td>
                        <td>@{{ sub_account.name }}</td>
                        <td>@{{ sub_account.hashrate['size'] + sub_account.hashrate['unit']}}</td>
                        <td>@{{ sub_account.hashrate_change }}</td>
                        <td>@{{ sub_account.reject_rate }}</td>
                        <td>@{{ sub_account.created_at }}</td>
                        <td>
                            <button v-on:click="sub_account_dashboard(sub_account.uid, sub_account.puid)">控制台</button>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
@endsection

@push('footer_script')
<script>
    require('modules/internal/admin');
</script>
@endpush
