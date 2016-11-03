const $ = require('jquery');
const Vue = require('../vue');
const getJSON = require('../ajax').getJSON;
const moment = require('/modules/lib/moment');

$('[data-toggle="tooltip"]').tooltip();

new Vue({
    el: '.earning',
    data: {
        fields: {
            page: 1,
            page_size: 50,
        },
        income: {},
        list: {},
        subsidy: {
            status: {},
            history: []
        }

    },
    filters: {
        addHs(v) {
            return `${v ? v : 'G'}H/s`;
        },
        formatTime(v){
            if (v != undefined) {
                var day = moment(v, "YYYY-MM-DD");
                return day.format('YYYY-MM-DD');
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
        fixed(v, num) {
            if (v != undefined) {
                return parseFloat(v).toFixed(num);
            }
        },

    },
    methods: {
        updateEarning: function () {
            var self = this;
            getJSON(`${window.__btccom.endpoint.rest}/account/earn-stats`)
                .then(data => {
                    self.income = data;
                })
        },
        updateStats: function () {
            var self = this;
            getJSON(`${window.__btccom.endpoint.rest}/account/earn-history`, self.fields)
                .then(data => {
                    self.list = data;

                    if ($('#pagination').data("twbs-pagination")) {
                        $('#pagination').twbsPagination('destroy');
                    }

                    $('#pagination').twbsPagination({
                        totalPages: self.list.page_count == 0 ? 1 : self.list.page_count,
                        visiblePages: 7,
                        first: '<<',
                        prev: '<',
                        next: '>',
                        last: '>>',
                        href: '',
                        startPage: parseInt(self.list.page),
                        initiateStartPageClick: false,
                        onPageClick: function (event, page) {
                            $('body').animate({scrollTop: '380px'}, 300);
                            $('#not-spa-demo-content').text('Page ' + page);
                            self.fields.page = page;
                            self.updateStats()
                        }
                    });
                })
            //.then(() => {
            //    setTimeout(() => {
            //        self.updateStats();
            //    }, 60000);
            //
            //});
        },
        getSubsidy: function () {
            var self = this;
            getJSON(`${window.__btccom.endpoint.rest}/account/rebates-status`)
                .then(data => {
                    // console.log(data);
                    self.subsidy.status = data;
                    $('#activeDay').text(self.subsidy.status.days_remain);
                })

        },
        getSubsidyHistory: function () {
            var self = this;
            getJSON(`${window.__btccom.endpoint.rest}/account/rebates-history`)
                .then(data=> {
                    // console.log(data);
                    self.subsidy.history = data;

                })
        }

    },
    ready() {
        this.getSubsidy();
        this.updateStats();
        this.updateEarning();
        this.getSubsidyHistory();

    }
});
