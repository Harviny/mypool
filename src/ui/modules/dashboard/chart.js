const getCharts = require('../Charts');
const url=`${window.__btccom.endpoint.rest}/worker/share-history`;

$(function () {
    getCharts(url);
    $('#pool-stats li').click(function () {
        $(this).addClass('active')
        $(this).siblings().removeClass('active')
        getCharts(url);
    })
})
