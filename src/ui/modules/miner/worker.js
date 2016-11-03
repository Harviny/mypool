const Vue = require('../vue');
const ajax = require('../ajax');
var dic = window.__btccom.trans_group;
var lastChecked = null;

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.mod').click(function () {
        $('.v-error').hide();
        $('.v-success').hide();
    })


});


Vue.config.delimiters = ['${', '}'];
new Vue({
    el: '.miners',
    data: {
        fields: {
            group: -1,
            page: 1,
            page_size: 50,
            status: 'all',
            order_by: 'worker_name',
            asc: 1,
            filter: '',
        },
        currentGroup: {},
        groups: {},
        worker: {}
    },
    filters: {
        name(v){
            if (v != undefined) {
                if (v == 'ALL') {
                    return dic.AllGroups;
                }
                else if (v == 'DEFAULT') {
                    return dic.Default;
                }
                else {
                    return v;
                }
            }
        },
        addHs(v) {
            return ` ${v ? v : 'G'}H/s`;
        },
        formatTime(v){
            return timestamp(v);
        },
        fixed(v, num) {
            if (v != undefined) {
                return parseFloat(v).toFixed(num);
            }
        }

    },
    methods: {
        updateStats: function () {
            let self = this;
            ajax.getJSON(`${window.__btccom.endpoint.rest}/worker/groups`,{page_size:25})
                .then(data => {
                    self.groups = data;
                    self.updateWorker();
                })
            //.always(()=>{//轮询
            //    setTimeout(() => {
            //        self.updateStats.call(this);
            //    }, 3000);
            //})
        },
        updateWorker: function (gid, status, order, sort, filter, page, page_size) {
            var self = this;
            self.fields = {
                group: gid == undefined ? self.fields.group : self.fields.group = gid,
                page: page == undefined ? self.fields.page : self.fields.page = page,
                page_size: page_size == undefined ? self.fields.page_size : self.fields.page_size = page_size,
                status: status == undefined ? self.fields.status : self.fields.status = status,
                order_by: order == undefined ? self.fields.order_by : self.fields.order_by = order,
                asc: sort == undefined ? self.fields.asc : self.fields.asc = sort,
                filter: filter == undefined ? self.fields.filter : self.fields.asc = filter
            }

            //修改浏览器URL地址
            let hisUrl = window.location.href.split('?')[0];
            if(history.pushState){
                window.history.replaceState({}, '0', hisUrl + '?id=' + self.fields.group);
            }


            // 当前选中的分组信息
            this.groups.list.forEach(symbol=> {
                if (symbol.gid == this.fields.group) {
                    self.currentGroup = symbol;
                }
            })
            $('#stAll').prop('checked',false)
            ajax.getJSON(`${window.__btccom.endpoint.rest}/worker`, self.fields)
                .then(data=> {

                    // 绑定checkbox 并且所有的矿机初始状态为未选中
                    data.data.forEach(symbol=> {
                        symbol.checked = false;  //
                    })

                    //data.data.forEach(ov=> {
                    //    self.worker.data.forEach(nv=> {
                    //        if (ov.worker_id == nv.worker_id) {
                    //            ov.checked = nv.checked;  // 保存矿机选中状态
                    //        }
                    //    })
                    //})

                    self.worker = data;

                    $('#stAll').click(function () {
                        self.worker.data.forEach(symbol=> {
                            if (this.checked) {
                                symbol.checked = true;
                            }
                            else {
                                symbol.checked = false;
                            }
                        })
                    })


                    if ($('#pagination').data("twbs-pagination")) {
                        $('#pagination').twbsPagination('destroy');
                    }
                    $('#pagination').twbsPagination({
                        totalPages: self.worker.page_count == 0 ? 1 : self.worker.page_count,
                        visiblePages: 7,
                        first: '<<',
                        prev: '<',
                        next: '>',
                        last: '>>',
                        href: '',
                        startPage: parseInt(self.fields.page),
                        initiateStartPageClick: false,
                        onPageClick: function (event, page) {
                            $('body').animate({scrollTop: '0px'}, 300);
                            $('#not-spa-demo-content').text('Page ' + page);
                            self.fields.page = page;
                            self.updateWorker()
                        }
                    });


                })
        },
        //组操作
        operateGroup: function (operate, id) {
            let self = this, url, query;
            $('.v-error').text('');
            if (operate == 'create') {
                id = document.getElementById('addGroupName').value;
                if (id == '') {
                    $('.v-error').show();
                    $('.v-error').text(dic.emptyName);
                    return false;
                }
                url = `${window.__btccom.endpoint.rest}/groups/${operate}`;
                query = {'group_name': id}
            }
            else {
                url = `${window.__btccom.endpoint.rest}/groups/${operate}/${id}`;
                query = {}
            }
            ajax.post(url, query)
                .then(data => {
                    if (data.status == 'exist') {
                        $('.v-error').show();
                        $('.v-error').text(dic.exist);
                    }
                    else if (data.status == true) {
                        $('#addGroup').modal('hide')
                        $('#delGroup').modal('hide')
                        if (operate == 'delete') {
                            self.fields.group = -1;
                        }
                        self.updateStats();
                    } else {
                        $('.v-error').show();
                        for(let key in data.err_msg){
                            $('.v-error').text(data.err_msg[key]);
                            return;
                        }

                    }
                })
        },
        //矿机操作
        operateWorker: function (gid) {
            let self = this, workerIds = '';

            self.worker.data.forEach(symbol=> {
                if (symbol.checked) {
                    workerIds += symbol.worker_id + ',';
                }
            })

            if (workerIds == '') {
                prompt('notChecked');
                return false;
            } else {
                workerIds = workerIds.substring(0, workerIds.length - 1);
            }

            ajax.post(`${window.__btccom.endpoint.rest}/worker/update`, {'worker_id': workerIds, 'group_id': gid})
                .then(data => {
                    if (data.status == true) {
                        if (gid == 0) {
                            prompt('remove');
                        }
                        self.updateWorker();
                        self.updateStats();
                    } else {
                        if (gid == 0) {
                            prompt('remove_not');
                        }
                    }
                })
        },
        //shift多选操作
        handleChecked: function () {
            let self = this;
            let e = e || window.event;
            let allBox = $('#minerTB input[type="checkbox"]');
            if (lastChecked && e.shiftKey) {
                let o = allBox.index(lastChecked);
                let n = allBox.index(e.target);
                let checkboxes = [];
                if (n > o) {
                    checkboxes = self.worker.data.slice(o + 1, n);
                } else {
                    checkboxes = self.worker.data.slice(n + 1, o + 1);
                }

                if (!$(e.target).is(':checked')) {
                    checkboxes.forEach(function (symbol) {
                        symbol.checked = false
                    })
                } else {
                    checkboxes.forEach(function (symbol) {
                        symbol.checked = true
                    })
                }
            }
            lastChecked = e.target;
        },
        clear:function(){
            $('.v-error').text('');
            document.getElementById('addGroupName').value='';

        }
    },
    ready() {
        if (!getQueryString('id') === null || !getQueryString('id') == '') {
            this.fields.group = getQueryString('id')
        }
        this.updateStats();
    }
});


// 弹出小窗
function prompt(temp) {
    $(".messageInfo").text(dic[temp]);
    $('#messageTip').modal({keyboard: true});
}

// 获取url参数
function getQueryString(name) {
    let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    let r = window.location.search.substr(1).match(reg);
    if (r != null) return r[2];
    return null;
}


function timestamp(value) {
    if (value == '' || value == undefined || value==0) {
        return '-';
    } else {
        let date = new Date(value * 1000),
            Y = date.getFullYear().toString() + '/',
            M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '/',
            D = date.getDate() < 10 ? '0' + (date.getDate()) + ' ' : date.getDate() + ' ',
            h = date.getHours() < 10 ? '0' + date.getHours() + ':' : h = date.getHours() + ':',
            m = date.getMinutes() < 10 ? '0' + date.getMinutes() + ' ' : date.getMinutes() + ' ';
        return Y + M + D + h + m;
    }
}
