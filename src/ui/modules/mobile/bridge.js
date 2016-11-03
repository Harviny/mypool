const $ = require('jquery');

function iOS() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}

// setup android webview bridge
function registerBridge() {
    var df = $.Deferred();
    var p = df.promise();
    if (iOS()) {
        setupWebViewJavascriptBridge(function(bridge) {
            df.resolve(bridge);
        });
    } else {
        if (window.WebViewJavascriptBridge) {
            setTimeout(function() {
                df.resolve(WebViewJavascriptBridge);
            }, 0);
        } else {
            document.addEventListener(
                'WebViewJavascriptBridgeReady'
                , function() {
                    df.resolve(WebViewJavascriptBridge);
                },
                false
            );
        }
        p = p.then(b => {
            b.init(message => {
                console.warn('[debug] got a message', message);
            });

            return b;
        });
    }
    return p;
}

function setupWebViewJavascriptBridge(callback) {
    if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
    if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
    window.WVJBCallbacks = [callback];
    var WVJBIframe = document.createElement('iframe');
    WVJBIframe.style.display = 'none';
    WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
    document.documentElement.appendChild(WVJBIframe);
    setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
}

module.exports = {
    _instance: null,
    getInstance() {
        if (!this._instance) {
            this._instance = registerBridge();
        }

        return this._instance;
    },
    call(method, data) {
        console.log('call %s, %o', method, data);

        return this.getInstance().then(function(bridge) {
            var df = $.Deferred();

            bridge.callHandler.call(null, method, data, function(response) {
                console.log('call handler response', response);

                response = JSON.parse(response);

                df.resolve(response);
            });

            return df.promise();
        });
    },
    register(method) {
        return this.getInstance().then(function(bridge) {
            const df = $.Deferred();
            bridge.registerHandler.call(null, method, function(data, responseCallback) {
                console.log(`handler called, method = ${method}, data = ${data}`);
                data = JSON.parse(data);
                df.resolve(data, responseCallback);
            });

            return df.promise();
        });
    }
};
