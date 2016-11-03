const echarts = require('echarts');
const getJSON = require('../ajax').getJSON;
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
            count: 24 * 3
        }
    } else {
        query = {
            dimension: '1d',
            count: 15
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
                    enterable: false,
                    backgroundColor: 'rgba(0,0,0,0.5)',
                    borderColor: '#333',
                    padding: 7,
                    textStyle: {
                        fontSize: 12,
                        fontWeight: 'lighter',
                    },
                    formatter: function (params) {
                        return `${dic.time}: ${timestamp(params[0].name, unit, 'all')} <br/>
                                ${params[0].seriesName}: ${params[0].value.toFixed(3)} ${data.unit}H/s <br/>`

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
                        textStyle: {
                            color: '#888',
                        },
                        formatter: function (v) {
                            return timestamp(v, unit)
                        }
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#aaa',
                        }
                    },
                },
                yAxis: [
                    {
                        name: dic.hashrate + '(' + data.unit + 'H/s)',
                        nameTextStyle: {
                            color: '#888',
                        },
                        boundaryGap: false,
                        splitLine: {
                            show: false
                        },
                        axisLabel: {
                            formatter: '{value} ',
                            textStyle: {
                                color: '#888',
                            },
                        },
                        axisLine: {
                            lineStyle: {
                                color: '#aaa',
                            }
                        },
                    },

                ],
                series: [
                    {
                        name: dic.hashrate,
                        smooth: true,
                        type: 'line',
                        yAxisIndex: 0,
                        data: data.tickers.map(t => +[t[1] * (1 - t[2])]),
                        symbol: 'emptyCircle',
                        symbolSize: 4,
                        itemStyle: {
                            normal: {
                                color: '#3c78c2',
                                //borderColor:'#fff',
                                //borderWidth:3,
                                lineStyle: {
                                    color: '#3c78c2',
                                    width: '2',
                                },
                            },
                            emphasis: {
                                color: '#3c78c2',
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                        offset: 0,
                                        color: '#BBD8EF'
                                    }, {
                                        offset: 1,
                                        color: '#fff'
                                    }]
                                )
                            }
                        },

                    },
                ]
            });
        })
        .always(() => {
            timer = setTimeout(() => {
                getCharts(url, text);
            }, 60000);
        });

    return;
}

module.exports = getCharts



