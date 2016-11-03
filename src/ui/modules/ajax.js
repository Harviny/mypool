const $ = require('jquery');
const accessKey = window.__btccom.ak;
const puid = window.__btccom.puid;
var i=0;

if (!accessKey) {
    console.error('accessKey not defined');
}


module.exports = {
    getJSON(url, query) {

        var fields={};
        if (accessKey == '0') {
            fields = {
                url,
                data: $.extend({}, query),
                dataType: 'json'
            }
        } else {
            fields = {
                url,
                data: $.extend({}, query, {access_key: accessKey, puid: puid}),
                dataType: 'json'
            }
        }
        return $
            .ajax(fields)
            .then(response => {
                if (response.err_no != 0) {
                    return $.Deferred().reject(response);
                }
                return response.data;
            })
            .then(null, response => {
                i++;
                if(i==1){
                    //alert('服务器错误,请稍后再试');
                }
                console.error(`GET ${url} ERROR`, response);
                return $.Deferred().reject(response);
            });
    },

    post(url, query){

        var fields={};
        if (query.access_key) {
            fields = {
                url,
                data: $.extend({}, query),
                dataType: 'json'
            }
        } else {
            fields = {
                url,
                data: $.extend({}, query, {access_key: accessKey, puid: puid}),
                dataType: 'json'
            }
        }

        return $
            .post(fields)
            .then(response => {
                if (response.err_no != 0) {
                    return response;
                }
                return response.data;
            })
            .then(null, response => {

                //alert('服务器错误,请稍后再试');
                console.error(`POST ${url} ERROR`, response);
                return $.Deferred().reject(response);
            });
    }
};