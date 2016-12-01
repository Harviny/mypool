const $ = require('jquery');
const Vue = require('../../vue');
var moment = require('modules/lib/moment');

var internal_api_endpoint = '/internal/api';

new Vue({
    el: '.server-list',
    data: {
        server_list: [],
        server_info_operation: 'create',
        server_info_form: {
            id: '',
            name: '',
            ip: '',
            cnt: '',
            created_at: ''
        },
        vip_user_operation: 'add',
        vip_user_server_id: '',
        search_vip_user_uid: '',
        search_vip_user_subaccount: [],
        add_vip_puid_list: []
    },
    methods: {
        update_server_list: function () {
            $.ajax({
                url : internal_api_endpoint + '/getVipServerList',
                type: "get",
                dataType: "json",
            }).then(response => {
                if (response.err_no != 0) {
                    alert('更新失败');
                } else {
                    this.$data.server_list = response.data;
                }
            })
        },
        show_vip_server_info: function (info, operation) {
            this.$data.server_info_form = info;
            this.$data.server_info_operation = operation;
        },
        add_vip_server: function () {
            $.ajax({
                url : internal_api_endpoint + '/addVipServer',
                type: "get",
                data: {
                    'name': this.$data.server_info_form.name,
                    'ip': this.$data.server_info_form.ip,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no == 0) {
                    $('#VipServerInfo').modal('hide');
                    this.update_server_list();
                } else if (response.err_no == 1){
                    for(var k in response.err_msg){
                        alert(response.err_msg[k]);
                        return '';
                    }
                } else {
                    alert('失败');
                }
            });
        },
        delete_vip_server: function () {
            $.ajax({
                url : internal_api_endpoint + '/delVipServer',
                type: "get",
                data: {
                    'id': this.$data.server_info_form.id,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no == 0) {
                    $('#VipServerInfo').modal('hide');
                    this.update_server_list();
                } else if (response.err_no == 1){
                    for(var k in response.err_msg){
                        alert(response.err_msg[k]);
                        return '';
                    }
                } else {
                    alert('失败');
                }
            });
        },
        update_vip_server_info: function () {
            $.ajax({
                url : internal_api_endpoint + '/updateVipServer',
                type: "get",
                data: {
                    'id': this.$data.server_info_form.id,
                    'name': this.$data.server_info_form.name,
                    'ip': this.$data.server_info_form.ip,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no == 0) {
                    $('#VipServerInfo').modal('hide');
                    this.update_server_list();
                } else if (response.err_no == 1){
                    for(var k in response.err_msg){
                        alert(response.err_msg[k]);
                        return '';
                    }
                } else {
                    alert('更新失败');
                }
            });
        },
        show_add_vip_user_form: function (server_id) {
            this.$data.vip_user_operation = 'search';
            this.$data.vip_user_server_id = server_id;
        },
        search_vip_puid: function () {
            this.$data.vip_user_operation = 'show';
            $.ajax({
                url : internal_api_endpoint + '/searchUserPuidList',
                type: "get",
                data: {
                    'uid': this.$data.search_vip_user_uid,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no == 0) {
                    this.$data.search_vip_user_subaccount = response.data;
                } else if (response.err_no == 1){
                    for(var k in response.err_msg){
                        alert(response.err_msg[k]);
                        return '';
                    }
                } else {
                    alert('更新失败');
                }
            });
        },
        add_vip_account: function () {
            $.ajax({
                url : internal_api_endpoint + '/addAccount2Vip',
                type: "get",
                data: {
                    'server_id': this.$data.vip_user_server_id,
                    'puid_list': this.$data.add_vip_puid_list,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no == 0) {
                    $('#addVipUser').modal('hide');
                    vip_list.update_vip_user_list();
                } else if (response.err_no == 1){
                    for(var k in response.err_msg){
                        alert(response.err_msg[k]);
                        return '';
                    }
                } else {
                    alert('更新失败');
                }
            });
        }

    },
    ready() {
        this.update_server_list();
    }
});

var vip_list = new Vue({
    el: '.vip-list',
    data: {
        sub_account_contact_info: {
            email: '',
            phone: ''
        },
        sub_account_note: '',
        sub_account_note_puid: '',
        vip_user_list: [],
        hashrate_dimension: 'day',
    },
    filters: {
        breakLine(text, limit) {
            if (! text) {
                return '';
            }
            if (text.length > limit) {
                return text.substring(0, limit) + '...';
            }
            return text;
        }
    },
    methods: {
        sub_account_dashboard: function (uid, puid) {
            getDashBoardLink(uid, puid);
        },
        show_user_contact_info: function (uid) {
            $.ajax({
                url : internal_api_endpoint + '/getUserInfoList',
                type: "get",
                dataType: "json",
                data: {
                    uid: uid,
                },
            }).then(response => {
                if (response.err_no != 0) {
                    alert('获取失败');
                } else {
                    // 初始化用户联系数据
                    this.$data.sub_account_contact_info.email = '';
                    this.$data.sub_account_contact_info.phone = '';

                    if (response.data[uid]['email']) {
                        this.$data.sub_account_contact_info.email = response.data[uid]['email'];
                    }
                    if (response.data[uid]['phone_number']) {
                        this.$data.sub_account_contact_info.phone = '+' +
                            response.data[uid]['phone_country_code'] + ' ' + response.data[uid]['phone_number'];
                    }
                }
            })
        },
        show_subaccount_note: function (puid, note) {
            this.$data.sub_account_note_puid = puid;
            this.$data.sub_account_note = note;
        },
        update_subaccount_note: function (puid, note) {
            $.ajax({
                url : internal_api_endpoint + '/updateSubaccountNote',
                type: "get",
                dataType: "json" +
                "",
                data: {
                    puid: puid,
                    note: note
                },
            }).then(response => {
                if (response.err_no != 0) {
                    alert('更新失败');
                } else {
                    $('.showSubaccountNote').modal('hide');
                    this.update_vip_user_list();
                }
            })
        },
        update_vip_user_list: function () {
            $.ajax({
                url : internal_api_endpoint + '/getVipUserList',
                type: "get",
                data: {
                    'dimension': this.$data.hashrate_dimension,
                },
                dataType: "json",
            }).then(response => {
                if (response.err_no != 0) {
                    alert('更新失败');
                } else {
                    this.$data.vip_user_list = response.data;
                }
            });
        },
        change_vip_user_list_dimension: function (dimension) {
            this.$data.hashrate_dimension = dimension;
            this.update_vip_user_list();
        },
        delete_vip: function (puid) {
            var confirm = window.confirm("是否删除该子账户的vip资格");
            if (confirm) {
                $.ajax({
                    url : internal_api_endpoint + '/delAccountVip',
                    type: "get",
                    data: {
                        'puid': puid,
                    },
                    dataType: "json",
                }).then(response => {
                    if (response.err_no != 0) {
                        alert('取消失败');
                    } else {
                        this.update_vip_user_list();
                    }
                });
            }
        }
    },
    ready() {
        this.update_vip_user_list();
    }

});


function getDashBoardLink(uid, puid) {
    $.ajax({
        url : internal_api_endpoint + '/getLoginLink',
        type: "get",
        dataType: "json",
        data: {
            uid: uid,
            puid: puid,
        },
    }).then(response => {
        if (response.err_no == 0) {
            var link = response.data['url'];
            prompt("在隐身窗口打开下面的链接:", link);
        } else {
            alert('获取失败');
        }
    })
}
