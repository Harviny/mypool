const $ = require('jquery');
const Vue = require('../../vue');
var moment = require('modules/lib/moment');

var internal_api_endpoint = '/internal/api';

function update_sub_account_list_data(query) {

    $.ajax({
        'url' : internal_api_endpoint + '/subAccountInfoList',
        'data' : query
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
        sub_account_list: []
    },
    methods : {
        sub_account_dashboard: function (uid, puid) {
            getDashBoardLink(uid, puid);
        }
    }
});


$('#sub_account_search').click(function () {
    var query = {
        account_type : $('#account_type').val(),
        account_value : $('#account_value').val(),
        date_time_dimension : $('#date_time_dimension').val(),
        date_time_value : $('#date_time_value').val(),
        order_type: $('#order_type').val(),
        order_value: $('#order_value').val()
    };
    update_sub_account_list_data(query)
});


$(document).ready(function(){
    update_sub_account_list_data({
        date_time_dimension : 'hour',
        date_time_value : moment().utc().format('YYYYMMDDHH'),
    });
});