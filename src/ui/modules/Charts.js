const echarts = require('echarts');
const getJSON = require('ajax').getJSON;
require('modules/lib/echarts_themes/macarons');
const chart = echarts.init(document.querySelector('.hashRate .echart'), 'macarons');
var dic = window.__btccom.trans_charts;
var timer;

chart.showLoading();

function timestamp(value, unit, type) {

    var date = new Date(value * 1000),
        Y = date.getFullYear().toString() + '/',
        M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '/',
        D = date.getDate() < 10 ? '0' + (date.getDate()) + ' ' : date.getDate() + ' ',
        h = date.getHours() < 10 ? '0' + date.getHours() + ':' : date.getHours() + ':',
        m = date.getMinutes() < 10 ? '0' + date.getMinutes() + '' : date.getMinutes() + '',
        s = date.getSeconds() < 10 ? ':0' + date.getSeconds() : ':' + date.getSeconds();

    if (unit == 'h') {
        if (type == 'all') {
            return Y + M + D + h + m + s;
        } else {
            return h + m;
        }
    } else {
        return M + D;
    }

}

function getCharts(url, text) {
    if (timer != undefined) {
        clearTimeout(timer);
    }
    var unit = $('#pool-stats>.active').attr('unit');
    if (unit == undefined || unit == '') {
        unit = 'h';
    }
    var query = {};
    if (unit == 'h') {
        query = {
            dimension: '1h',
            start_ts: Math.floor((Date.now() - 24 * 3 * 3600 * 1000) / 1000),
            real_point: 1,
            count: 24 * 3
        }
    } else {
        query = {
            dimension: '1d',
            start_ts: Math.floor((Date.now() - 24 * 30 * 3600 * 1000) / 1000),
            real_point: 1,
            count: 30
        }
    }

    getJSON(url, query)
        .then(data => {
            chart.hideLoading();

            chart.setOption({
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        animation: false
                    },
                    formatter: function (params) {
                        //console.log(params)
                        if (params[0] && params[1]) {
                            return `${dic.time}: ${timestamp(params[0].name, unit, 'all')} <br/>
                                     ${params[0].seriesName}: ${params[0].value.toFixed(3)} ${data.shares_unit}H/s <br/>
                                     ${params[1].seriesName}: ${params[1].value.toFixed(3)}%`
                        }
                        else {
                            if (params[0].seriesIndex == 0) {
                                return `${dic.time}: ${timestamp(params[0].name, unit, 'all')} <br/>
                                     ${params[0].seriesName}: ${params[0].value.toFixed(3)} ${data.shares_unit}H/s`
                            } else {
                                return `${dic.time}: ${timestamp(params[0].name, unit, 'all')} <br/>
                                     ${params[0].seriesName}: ${params[0].value.toFixed(3)}%`
                            }

                        }
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    data: data.tickers.map(t => t[0]),
                    splitLine: {
                        show: false
                    },
                    boundaryGap: false,
                    offset: 10,
                    axisLabel: {
                        formatter: function (v) {
                            return timestamp(v, unit)
                        }
                    }
                },
                yAxis: [
                    {
                        name: dic.hashrate + '(' + data.shares_unit + 'H/s)',
                        boundaryGap: false,
                        splitLine: {
                            show: false
                        },
                        axisLabel: {
                            formatter: '{value} '
                        }
                    },
                    {
                        name: dic.reject + '(%)',
                        boundaryGap: false,
                        //splitNumber:3,
                        min: 0,
                        max:getRejectPrecent(data),
                        splitLine: {
                            show: false
                        },
                        axisLabel: {
                            formatter: function (v) {
                                return v
                            }
                        }
                    }
                ],
                series: [
                    {
                        name: dic.hashrate,
                        type: 'line',
                        yAxisIndex: 0,
                        data: data.tickers.map(t => +t[1]),
                        //itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        smooth: true,
                    },
                    {
                        name: dic.reject,
                        type: 'line',
                        yAxisIndex: 1,
                        //itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data: data.tickers.map(t => t[2] * 100),
                        smooth: true,
                    }
                ]
            });
        })
        .always(() => {
            timer = setTimeout(() => {
                getCharts(url, text);
            }, 2000);
        });
}

module.exports = getCharts

function getRejectPrecent(data) {
    let rejectPrecent = 10;
    for (let i = 0; i < data.tickers.length; i++) {
        if (parseFloat(data.tickers[i][2]*100) > 10) {
            rejectPrecent = 100;
            break;
        }
    }
    return rejectPrecent;
}

