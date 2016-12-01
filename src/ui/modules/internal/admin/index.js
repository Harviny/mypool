const $ = require('jquery');
const Vue = require('../../vue');
var moment = require('modules/lib/moment');

var internal_api_endpoint = '/internal/api';
var uc_endpoint = window.__btccom.endpoint.uc_endpoint;

var vm = new Vue({
    el: '.adminIndex',
    data: {
        search_user_list: false,
        search_user_type: 'email',
        search_user_value: '',

        account_type: 'uid',
        account_value: '',
        date_time_dimension: 'day',
        date_time_value: '',
        order_type: 'hashrate',
        order_value: 'desc',
    },
    methods: {
        getUIDForUC: function (user_type, user_value) {
            $.ajax({
                'url' : uc_endpoint + '/auth/god-query-user',
                'data' : {
                    q : user_value,
                    type : user_type,
                },
            }).then(response => {
                if (response.err_no == 0) {
                    vm.$data.search_user_list = response.data;
                } else {
                    vm.$data.search_user_list = [];
                    alert('接口错误: ' + response.err_msg);
                }
            });
        },
        setSearchUser: function (uid) {
            vm.$data.account_type = 'uid';
            vm.$data.account_value = uid;

            // 搜索完成清空列表
            vm.$data.search_user_value = '';
            vm.$data.search_user_list = false;
        },
        update_sub_account_list_data: function () {
            update_sub_account_list();
        }
    }
});


function update_sub_account_list() {
    $.ajax({
        'url' : internal_api_endpoint + '/subAccountInfoList',
        'data' : {
            account_type : vm.$data.account_type,
            account_value : vm.$data.account_value,
            date_time_dimension : vm.$data.date_time_dimension,
            date_time_value : vm.$data.date_time_value,
            order_type: vm.$data.order_type,
            order_value: vm.$data.order_value
        }
    }).then(response => {
        if (response.err_no == 0) {
            sub_account_list_data.$set('sub_account_list', response.data.account_list);
        } else {
            alert('接口错误: ' + response.err_msg);
        }
    });
}


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

var sub_account_list_data = new Vue({
    el: '#sub_account_list',
    data: {
        sub_account_list: [],
        sub_account_note: '',
        sub_account_note_puid: '',
        sub_account_contact_info: {
            email : '',
            phone : '',
        },
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
    methods : {
        sub_account_dashboard: function (uid, puid) {
            getDashBoardLink(uid, puid);
        },
        show_subaccount_note: function (puid, note) {
            this.$data.sub_account_note_puid = puid;
            this.$data.sub_account_note = note;
        },
        update_subaccount_note: function (puid, note) {
            $.ajax({
                url : internal_api_endpoint + '/updateSubaccountNote',
                type: "get",
                dataType: "json",
                data: {
                    puid: puid,
                    note: note
                },
            }).then(response => {
                if (response.err_no != 0) {
                    alert('更新失败');
                } else {
                    $('.showSubaccountNote').modal('hide');
                    update_sub_account_list()
                }
            })
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
        }
    }
});

$(document).ready(function(){
    update_sub_account_list();
});