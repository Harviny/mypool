const getCharts = require('../Charts');
var worker_id= 0;
if (!getQueryString('id') === null || !getQueryString('id') == '') {
    worker_id = getQueryString('id')
}

var url=`${window.__btccom.endpoint.rest}/worker/${worker_id}/share-history`;


$(function () {
    getCharts(url);
    $('#pool-stats li').click(function () {
        $(this).addClass('active')
        $(this).siblings().removeClass('active')
        getCharts(url);
    })
})

/**获取url参数*/
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return r[2];
    return null;
}

