const Vue = require('../vue');
const moment = require('/modules/lib/moment.js');
const getJSON = require('../ajax').getJSON;

var dic = window.__btccom.trans_miner;
var timer;
function updateWorkers() {
    if (timer != undefined) {
        clearTimeout(timer);
    }
    getJSON(`${window.__btccom.endpoint.rest}/worker/${this.worker_id}`)
        .then(data => {
            data.data.reject_percent=data.data.reject_percent*100;
            this.list = data.data;
        })
        .always(() => {
           timer= setTimeout(() => {
                updateWorkers.call(this);
            }, 3000);
        });
}


new Vue({
    el: '.miner',
    data: {
        worker_id: 0,
        list: {},
    },
    filters: {
        addHs(v) {
            return `${v ? v : 'G'}H/s`;
        },
        formatTime(v){
            if (v == undefined || v == 0) {
                return '-';
            }
            else {
                var nowstamp = Date.parse(new Date()) / 1000;

                var nTime = nowstamp - v;

                var day = Math.floor(nTime / 86400);
                var hours = Math.floor(nTime % 86400 / 3600);
                var minute = Math.floor(nTime % 86400 % 3600 / 60);
                var seconds = Math.floor(nTime % 86400 % 3600 % 60 % 60);

                if (day > 0) {
                    return timestamp(v);
                }
                else if (hours == 0 && minute != 0) {
                    return `${minute}${dic.mins}${dic.ago}`;
                }
                else if (hours == 0 && minute == 0) {
                    return `${seconds}${dic.seconds}${dic.ago}`;
                }
                else {
                    return `${hours}${dic.hours}${minute}${dic.mins}${dic.ago}`;
                }


            }
        },
        stats(v){
            if (v != undefined) {
                return dic[v];
            }

        }

    },
    ready() {
        if (!getQueryString('id') === null || !getQueryString('id') == '') {
            this.worker_id = getQueryString('id')
        }

        updateWorkers.call(this);
    }
});


/**获取url参数*/
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return r[2];
    return null;
}

function timestamp(value) {
    if (value == '' || value == undefined) {
        return '';
    } else {
        var date = new Date(value * 1000),
            Y = date.getFullYear().toString() + '/',
            M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '/',
            D = date.getDate() < 10 ? '0' + (date.getDate()) + ' ' : date.getDate() + ' ',
            h = date.getHours() < 10 ? '0' + date.getHours() + ':' : h = date.getHours() + ':',
            m = date.getMinutes() < 10 ? '0' + date.getMinutes() + ' ' : date.getMinutes() + ' ';
        return Y + M + D + h + m;
    }

}
