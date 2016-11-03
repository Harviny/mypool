const $ = require('jquery');
const Vue = require('../vue');
const getJSON = require('../ajax').getJSON;

new Vue({
    el: '.poolStats',
    data: {
        fields: {
            page: 1,
            page_size: 50,
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
        formatTime(v){
            return timestamp(v);
        },
        formatBlock(v){
            if (v != undefined) {
                return (v / Math.pow(10, 8)).toFixed(8);
            }
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
            //const url = `https://cn-pool.api.btc.com/public/v1/pool/stats/merge`;
            const url = `${window.__btccom.endpoint.realtime}/pool/stats/merge`;
            getJSON(url)
                .then(data => {
                    data.shares.shares_15m=(data.shares.shares_15m*(1-data.reject['15m'])).toFixed(3);
                    self.stats = data;
                })
        },
        updateBlocks: function () {
            var self = this;
            //const url = `https://cn-pool.api.btc.com/public/v1/pool/blocks/merge?page=1&page_size=20`;
            const url = `${window.__btccom.endpoint.realtime}/pool/blocks/merge`;
            getJSON(url, self.fields)
                .then(data => {
                    self.list = data;

                    if ($('#pagination').data("twbs-pagination")) {
                        $('#pagination').twbsPagination('destroy');
                    }

                    $('#pagination').twbsPagination({
                        totalPages: self.list.blocks.last_page == 0 ? 1 : self.list.blocks.last_page,
                        visiblePages: 7,
                        first: '<<',
                        prev: '<',
                        next: '>',
                        last: '>>',
                        //href: '',
                        startPage: parseInt(self.list.blocks.current_page),
                        initiateStartPageClick: false,
                        onPageClick: function (event, page) {
                            $('body').animate({scrollTop: '780px'}, 300);
                            $('#not-spa-demo-content').text('Page ' + page);
                            self.fields.page = page;
                            self.updateBlocks()
                        }
                    });
                })
            //.then(() => {
            //    setTimeout(() => {
            //        self.updateBlocks();
            //    }, 60000);
            //
            //});
        }

    },
    ready() {
        this.updateStats();
        this.updateBlocks();
    }
});

function timestamp(value) {
    if (value == '' || value == undefined) {
        return '';
    } else {
        var date = new Date(value * 1000),
            Y = date.getFullYear().toString() + '/',
            M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '/',
            D = date.getDate() < 10 ? '0' + (date.getDate()) + ' ' : date.getDate() + ' ',
            h = date.getHours() < 10 ? '0' + date.getHours() + ':' : h = date.getHours() + ':',
            m = date.getMinutes() < 10 ? '0' + date.getMinutes() + ':' : date.getMinutes() + ':',
            s = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
        return Y + M + D + h + m + s;
    }
}