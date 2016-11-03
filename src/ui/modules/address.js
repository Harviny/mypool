const Vue = require('/modules/vue');
const getJSON = require('ajax').getJSON;
const post = require('ajax').post;

var lang = $('html')[0].lang;
if (~lang.indexOf('zh')) {
    lang = 'zh-cn';
} else {
    lang = 'en';
}

new Vue({
    el: '.settings',
    data: {
        flow: 1,
        newAddress: '',
        contact: 'mail',
        code: '',
        error_num: 0,  // 0:正常 ,-1:非正常
        userInfo: {
            contact: {
                phone: {}
            }
        },
        verify: {},
        nmc_new_address: '',
        nmc_error_num: 0,
        subsidy_new_address:'',
        subsidy_error_num:0

    },
    filters: {
        loading(v){
            if (v !=undefined) {
                $('.loading').hide();
                $('.alert-warning').show();
                return v;
            }else{
                $('.alert-warning').hide();
            }
        }
    },
    methods: {
        flow1: function () { //获取基本信息
            var self = this;
            self.flow = 1;
            self.newAddress = '';
            self.code = '';

            if (self.userInfo.user_name == '' || self.userInfo.user_name == undefined
                || self.userInfo.nmc_address == '' || self.userInfo.nmc_address == undefined
                || self.userInfo.rebates_address == '' || self.userInfo.rebates_address == undefined)
            {
                getJSON(`${window.__btccom.endpoint.rest}/account/info`)
                    .then(data => {
                        //console.log(data);
                        self.userInfo = data;
                    });
            }
        },
        flow2: function () { //填写新地址
            var self = this;
            self.error_num = 0;
            self.flow = 2;
        },
        flow3: function () { // 选择验证方式
            var self = this;
            var reg = /^[1-9A-Za-z]{26,35}$/;

            if (self.newAddress.trim() == '' || !reg.test(self.newAddress.trim())) {
                self.error_num = -1;
                return false;
            }
            self.error_num = 0;
            if (self.userInfo.contact.mail == '' || self.userInfo.contact.phone.number == '') {
                self.flow4()
            } else {
                self.flow = 3;
            }

        },
        flow4: function () { //填写验证码
            var self = this;
            self.flow = 4;
            // 邮件和短信 只有一种方式存在时.
            if (self.userInfo.contact.mail == '' || self.userInfo.contact.phone.number == '') {
                if (self.userInfo.contact.mail == '') {
                    self.contact = 'sms';
                } else {
                    self.contact = 'mail';
                }

            }
            getJSON(`${window.__btccom.endpoint.rest}/account/verify-code/${self.contact}`)
                .then(data => {
                    if (data.success == true) {
                        self.verify = data;
                    } else {
                        //console.log(data);
                        $('#errorMsg').modal('show');
                        $('#setAddress').modal('hide');
                    }

                });

        },
        flow5: function () { //验证码验证
            var self = this, query;
            if (self.code == '') {
                self.error_num = -1;
                return false;
            }
            self.error_num = 0;
            query = {
                new_address: $.trim(self.newAddress),
                verify_code: $.trim(self.code),
                verify_mode: self.contact,
                verify_id: self.verify.uuid
            }
            post(`${window.__btccom.endpoint.rest}/account/address/update`, query)
                .then(data => {
                    if (data.status) {
                        if (data.status == true) {
                            self.verify = data;
                            $('#successUpdate').modal('show');
                            $('#setAddress').modal('hide');
                        }
                    }
                    else {
                        self.error_num = -1;
                        for (let key in data.err_msg) {
                            $('.error-info').text(data.err_msg[key]);
                            return;
                        }

                    }

                });
        },

        updateNMCAddress: function () {
            var self = this;
            post(`${window.__btccom.endpoint.rest}/account/nmc/address/update`, {new_address:self.nmc_new_address.trim()})
                .then(data => {
                    if (data.status) {
                        if (data.status == true) {
                            $('#successUpdate').modal('show');
                            $('#setNMCAddress').modal('hide');
                        }
                    }
                    else {
                        self.nmc_error_num = -1;
                        for (let key in data.err_msg) {
                            $('.nmc-error-info').text(data.err_msg[key]);
                            return;
                        }
                    }

                });
        },
        updateSubsidyAddress: function () {
            var self = this;
            post(`${window.__btccom.endpoint.rest}/account/rebates/address/update`, {new_address:self.subsidy_new_address.trim()})
                .then(data => {
                    if (data.status) {
                        if (data.status == true) {
                            $('#successUpdate').modal('show');
                            $('#setSubsidyAddress').modal('hide');
                        }
                    }
                    else {
                        self.subsidy_error_num = -1;
                        for (let key in data.err_msg) {
                            $('.subsidy-error-info').text(data.err_msg[key]);
                            return;
                        }
                    }

                });
        },
        clear:function(){
            this.nmc_error_num=0;
            this.nmc_new_address='';
            this.subsidy_new_address='';
            this.subsidy_error_num=0;
        }
    },
    ready() {
        //if(accessKey!=0){
        //    this.flow1();
        //}
    }
});
