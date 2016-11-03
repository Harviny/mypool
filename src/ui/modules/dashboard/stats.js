const Vue = require('../vue');
const getJSON = require('../ajax').getJSON;
var dic = window.__btccom.trans_group;
var lang = $('html')[0].lang;
if (~lang.indexOf('zh')) {
    lang = 'zh-cn';
} else {
    lang = 'en';
}

var timer1,timer2,timer3,timer4;

function updateStats() {
    if (timer1 != undefined) {
        clearTimeout(timer1);
    }
    getJSON(`${window.__btccom.endpoint.rest}/realtime/stats`, {'worker_id': 0})
        .then(data => {
            this.shares_1m = data[0].shares_1m;
            this.shares_5m = data[0].shares_5m;
            this.shares_15m = data[0].shares_15m;
            this.shares_unit = data[0].shares_unit;
            timer1= setTimeout(() => {
                updateStats.call(this);
            }, 3000);
        });
}

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
            timer2=  setTimeout(() => {
                updateWorkers.call(this);
            }, 3000);
        });
}

function updateGroups() {
    if (timer3 != undefined) {
        clearTimeout(timer3);
    }
    getJSON(`${window.__btccom.endpoint.rest}/worker/groups`)
        .then(data => {
            this.groups = data;
        })
        .always(()=> {//轮询
            timer3=  setTimeout(() => {
                updateGroups.call(this);
            }, 10000);
        })
}

function updateIncome() {
    if (timer4 != undefined) {
        clearTimeout(timer4);
    }
    getJSON(`${window.__btccom.endpoint.rest}/account/earn-stats`)
        .then(data => {
            this.earnings_today = data.earnings_today/Math.pow(10,8);
            this.earnings_yesterday = data.earnings_yesterday/Math.pow(10,8);
            this.income = data;
        })
        .always(()=> {//轮询
            timer4= setTimeout(() => {
                updateIncome.call(this);
            }, 3000);
        })

}

function networkStatus() {
    getJSON(`${window.__btccom.endpoint.rest}/pool/status`)
        .then(data => {
            this.networkStatus = data;
        })
}

new Vue({
    el: '.dashboard',
    data: {
        shares_1m: 0,
        shares_5m: 0,
        shares_15m: 0,
        shares_unit: 'G',
        workers_total: 0,
        workers_active: 0,
        workers_inactive: 0,
        profit_yesterday: 0,
        profit_today: 0,
        earnings_today:0,
        earnings_yesterday:0,
        groups: {},
        income: {},
        networkStatus: {}
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
                return (v / Math.pow(10, 8)).toFixed(8);
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
        formatTime(v,type){
            if(v == undefined || v==0){
                return '-';
            }
            else {
                var timestamp = Date.parse(new Date())/1000;

                if(type=='pending'){
                    var nTime = timestamp - v;
                }else{
                    var nTime =  v - timestamp;
                }
                var day= Math.floor(nTime/86400);
                var hours= Math.floor(nTime%86400/3600);
                var minute= Math.floor(nTime%86400%3600/60);

                if(type=='pending'){
                    if(day==0){
                        return `${hours}${dic.h} ${minute}${dic.m} ${dic.ago}`;
                    }else{
                        return `${day}${dic.d}  ${hours}${dic.h}  ${minute}${dic.m}  ${dic.ago}`;
                    }
                }else{
                    return `${day}${dic.d} ${hours}${dic.h}`;
                }

            }
        },
        rate(v){
            if (v != undefined) {
                if(lang=='zh-cn'){
                    return `￥ ${parseFloat(v * this.networkStatus.exchange_rate.BTC2CNY).toFixed(2)}`;
                }else{
                    return `$ ${parseFloat(v * this.networkStatus.exchange_rate.BTC2USD).toFixed(2)}`;
                }
            }
        }

    },
    ready() {
        updateStats.call(this);
        updateWorkers.call(this);
        updateGroups.call(this);
        updateIncome.call(this);
        networkStatus.call(this);

        //updateProfit.call(this);
    }
});
