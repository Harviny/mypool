const Vue = require('../vue');
const moment = require('/modules/lib/moment');
const getJSON = require('../ajax').getJSON;
const io = require('../lib/socket.io');
let dic = window.__btccom.trans_group;
let lang = $('html')[0].lang;
~lang.indexOf('zh') ? lang = 'zh-cn' : lang = 'en';
let timer1, timer2, timer3, timer4;

const socket = io(window.__btccom.endpoint.eventstream, {
    path: '/v1/socket.io',
    query: `puid=${window.__btccom.puid}&access_key=${window.__btccom.ak}`
});

/** 算力信息*/
function updateStats() {
    if (timer1 != undefined) {
        clearTimeout(timer1);
    }
    getJSON(`${window.__btccom.endpoint.rest}/realtime/hashrate`, {'worker_id': 0})
        .then(data => {
            this.shares_15m = data.shares_15m;
            this.shares_1d = data.shares_1d;
            this.shares_15m_unit = data.shares_15m_unit;
            this.shares_1d_unit = data.shares_1d_unit;
            timer1 = setTimeout(() => {
                updateStats.call(this);
            }, 3000);
        });
}
/** 矿工信息*/
function updateWorkers() {
    if (timer2 != undefined) {
        clearTimeout(timer2);
    }
    getJSON(`${window.__btccom.endpoint.rest}/worker/stats`)
        .then(data => {
            this.workers_total = data.workers_total;
            this.workers_active = data.workers_active;
            this.workers_inactive = data.workers_inactive;
        })
        .always(() => {
            timer2 = setTimeout(() => {
                updateWorkers.call(this);
            }, 3000);
        });
}

/**分组*/
function updateGroups() {
    if (timer3 != undefined) {
        clearTimeout(timer3);
    }
    getJSON(`${window.__btccom.endpoint.rest}/worker/groups`,{page_size: 20,})
        .then(data => {
            this.groups = data;
        })
        .always(()=> {//轮询
            timer3 = setTimeout(() => {
                updateGroups.call(this);
            }, 10000);
        })
}

/**收益*/
function updateIncome() {
    if (timer4 != undefined) {
        clearTimeout(timer4);
    }
    getJSON(`${window.__btccom.endpoint.rest}/account/earn-stats`)
        .then(data => {
            this.earnings_today = data.earnings_today / Math.pow(10, 8);
            this.earnings_yesterday = data.earnings_yesterday / Math.pow(10, 8);
            this.income = data;
        })
        .always(()=> {//轮询
            timer4 = setTimeout(() => {
                updateIncome.call(this);
            }, 3000);
        })

}

/**全网算力,难度..*/
function networkStatus() {
    const url = `${window.__btccom.endpoint.realtime}/pool/stats/merge`;
    getJSON(`${window.__btccom.endpoint.rest}/pool/status`)
        .then(data => {
            this.networkStatus = data;
            return  getJSON(url)
        })
        .then(data => {
            this.networkStatus.pool_hashrate=(data.shares.shares_15m*(1-data.reject['15m'])).toFixed(3);
        })
}

/**挖矿签到历史记录,补贴收益*/
function getSubsidy() {
    var self = this;
    getJSON(`${window.__btccom.endpoint.rest}/account/rebates-status`)
        .then(data => {
            self.subsidy.status = data;
            $('#activeDay').text(self.subsidy.status.days_remain);
        })

}
function getSubsidyHistory() {
    var self = this;
    getJSON(`${window.__btccom.endpoint.rest}/account/rebates-history`)
        .then(data=> {
            self.subsidy.history = data;
        })
}

/**event日志*/
function getlogs() {
    // 连接失败
    socket.on('connect_error', e => {
        console.warn(`connect error`, e);
    });

    // 重新连接成功
    socket.on('reconnect', n => {
        console.log(`reconnected, ${n}`);
        this.eventMap.logs.length = 0; //清除数据
    });

    socket.on('latest_logs', data=> {
        console.log('logs', data);
        data.logs.map(log=> {
            log._hover = '_out';
            this.eventMap.logs.unshift(log);//添加latest_logs日志
        })
        this.eventMap.logs.unshift({tip: true, latest_logs: true, count: 1, event_id: 1});// 分割线
    })

    socket.on('logs', data=> {
        //console.log('logs', data);
        this.eventMap.logs.unshift({tip: true, skipCount: true, count: data.skipCount, event_id: 0}); // skipCount
        data.logs.map(log=> {
            log._hover = '_out';
            this.eventMap.logs.unshift(log);
        })
        if (this.eventMap.logs.length > this.eventMap.maxCount) {
            this.eventMap.logs = this.eventMap.logs.slice(0, this.eventMap.maxCount); //保持最大长度maxCount
        }
    })
}

new Vue({
    el: '.dashboard',
    data: {
        shares_1m: 0,
        shares_5m: 0,
        shares_15m: 0,
        shares_15m_unit: 'G',
        shares_1d: 0,
        shares_1d_unit: 'G',
        workers_total: 0,
        workers_active: 0,
        workers_inactive: 0,
        profit_yesterday: 0,
        profit_today: 0,
        earnings_today: 0,
        earnings_yesterday: 0,
        groups: {
            list: []
        },
        income: {},
        networkStatus: {},
        eventMap: {
            logs: [],
            maxCount: 100,
            _hover: false
        },
        subsidy: {
            status: {},
            history: []
        }
    },
    filters: {
        addHs(v) {
            return `${v ? v : 'G'}H/s`;
        },
        name(v){
            if (v == 'DEFAULT') {
                return dic.Default;
            }
            else {
                return v;
            }
        },
        fixed(v, num) {
            if (v != undefined) {
                return parseFloat(v).toFixed(num);
            }
        },
        formatBlock(v){
            if (v != undefined) {
                if (v == 0) {
                    return '-';
                } else {
                    return (v / Math.pow(10, 8)).toFixed(8);
                }
            }
        },
        diff(v, type) {
            var unit = ["", "k", "M", "G", "T", "P", "E", "Z", "Y"];
            var index = 0;

            if (v == 0 || v == "" || v == undefined) {
                v = 0;
            } else {
                while (v >= 1000) {
                    v = v / 1000;
                    index++;
                }
            }
            if (type == 'value') {
                return parseFloat(v).toFixed(2);
            } else {
                return unit[index];
            }
        },
        pending(v){
            if (v == 0 || v == "" || v == undefined) {
                return dic.none;
            } else {
                return `${(v / Math.pow(10, 8)).toFixed(8)}`;
            }
        },
        formatTime(v, type){
            if (v == undefined || v == 0) {
                return '-';
            }
            else {
                var timestamp = Date.parse(new Date()) / 1000;

                if (type == 'pending' || type == 'events') {
                    var nTime = timestamp - v;
                } else {
                    var nTime = v - timestamp;
                }
                var day = Math.floor(nTime / 86400);
                var hours = Math.floor(nTime % 86400 / 3600);
                var minute = Math.floor(nTime % 86400 % 3600 / 60);

                if (type == 'pending') {
                    if (day == 0) {
                        return `${hours}${dic.h} ${minute}${dic.m} ${dic.ago}`;
                    } else {
                        return `${day}${dic.d}  ${hours}${dic.h}  ${minute}${dic.m}  ${dic.ago}`;
                    }
                }
                else if (type == 'events') {
                    return moment(v * 1000).format('MM/DD  HH:mm:ss');
                }
                else if (type == 'subsidy') {
                    var day = moment(v, "YYYY-MM-DD");
                    return day.format('YYYY-MM-DD');
                }
                else {
                    return `${day}${dic.d} ${hours}${dic.h}`;
                }
            }
        },
        rate(v){
            if (v != undefined) {
                if (lang == 'zh-cn') {
                    return `￥ ${parseFloat(v * this.networkStatus.exchange_rate.BTC2CNY).toFixed(2)}`;
                } else {
                    return `$ ${parseFloat(v * this.networkStatus.exchange_rate.BTC2USD).toFixed(2)}`;
                }
            }
        }
    },
    methods: {
        onHover: function (name, hover) {
            var self = this;
            self.eventMap.logs.map(log=> {
                if (log.content) {
                    if (log.content.worker_name == name) {
                        hover ? log._hover = '_hover' : log._hover = '_out';
                    }
                }
            })
        },

    },
    ready() {
        updateStats.call(this);
        updateWorkers.call(this);
        updateGroups.call(this);
        updateIncome.call(this);
        networkStatus.call(this);
        getlogs.call(this);
        getSubsidy.call(this);
        getSubsidyHistory.call(this);
    }
});


Array.prototype.remove = function (val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};