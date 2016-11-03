const Vue = require('../vue');
const getJSON = require('../ajax').getJSON;
const getCharts = require('charts');
const url = `${window.__btccom.endpoint.realtime}/pool/share-history/merge`;
//const url = `https://cn-pool.api.btc.com/public/v1/pool/share-history/merge?dimension=1h&count=72`;
var timer1, timer2;
getCharts(url);

new Vue({
    el: '.hashRate',
    data: {
        rewards_count: 0,
        fields: {
            page: 1,
            page_size: 20,
        },
        stats: {
            shares: {},
            reject: {},
        },
        list: {
            blocks: {}
        },
    },
    filters: {
        addHs(v) {
            return `${v ? v : 'G'}H/s`;
        },
        formatBlock(v){
            return (v / Math.pow(10, 8)).toFixed(8);
        },
        fixed(v, num) {
            if (v != undefined) {
                return parseFloat(v).toFixed(num);
            }
        }
    },
    methods: {
        updateStats: function () {
            var self = this;
            if (timer1 != undefined) {
                clearTimeout(timer1);
            }
            //const url = `https://cn-pool.api.btc.com/public/v1/pool/stats/merge`;
            const url = `${window.__btccom.endpoint.realtime}/pool/stats/merge`;
            getJSON(url)
                .then(data => {
                    data.shares.shares_15m = data.shares.shares_15m * (1 - data.reject['15m']);
                    self.stats = data;
                })
                .then(() => {
                    timer1 = setTimeout(() => {
                        self.updateStats();
                    }, 3000);
                });
        },
        updateBlocks: function () {
            var self = this;
            if (timer2 != undefined) {
                clearTimeout(timer2);
            }
            // const url = `https://cn-pool.api.btc.com/public/v1/pool/blocks/merge?page=1&page_size=20`;
            const url = `${window.__btccom.endpoint.realtime}/pool/blocks/merge`;
            getJSON(url, self.fields)
                .then(data => {
                    self.list = data;
                    self.rewards_count = (data.rewards_count / Math.pow(10, 8)).toFixed(2);
                })
                .then(() => {
                    timer2 = setTimeout(() => {
                        self.updateBlocks();
                    }, 3000);

                });
        }

    },
    ready() {
        this.updateStats();
        this.updateBlocks();
    }
});
