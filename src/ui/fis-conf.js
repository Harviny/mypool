'use strict';

const DOMAIN = process.env.DOMAIN;

if (!DOMAIN) {
    fis.log.error('DOMAIN Not Defined');
    process.exit();
}

const uglifyPlugin = fis.plugin('uglify-js', {
    compress : {
        drop_console: true,
        dead_code: true,
        drop_debugger: true,
    }
});

fis.set('project.md5Connector', '.');

fis.set('project.ignore', ['node_modules/**', 'output/**', 'fis*.js', 'package.json']);

fis
    .hook('commonjs', {
        paths: {
            bootstrap: '/modules/lib/bootstrap.js',
            cookie: '/modules/lib/cookie.js',
            echarts: '/modules/lib/echarts.js',
            jquery: '/modules/lib/jquery.js',
            vue: '/modules/lib/vue.js'
        }
    })
    .match('*', {
        release: '/public/assets$0',
        url: '/assets$0',
        domain: DOMAIN
    })
    .match('::package', {
        // spriter: fis.plugin('csssprites')
    })
    // js
    .match('/modules/**.js', {
        parser: fis.plugin('babel'),
        isMod: true
    })
    .match('/modules/lib/*.js', {
        parser: null,
        optimizer: null,
    })
    .match('*.blade.php:js', {
        parser: fis.plugin('babel')
    })
    // less
    .match('/style/*/**', {
        useMap: false,
        release: false
    })
    .match('/style/*/**.less', {
        parser: fis.plugin('less')
    })
    .match('/style/*.less', {
        parser: fis.plugin('less'),
        rExt: '.css'
    })
    // templates
    .match('/views/**', {
        release: '/resources$0',
        dynamicRequire: true
    })
    .match('/assets.json', {
        release: '/resources/assets_map$0'
    });

fis.media('prod')
    .hook('commonjs', {
        paths: {
            bootstrap: '/modules/lib/bootstrap.js',
            cookie: '/modules/lib/cookie.js',
            echarts: '/modules/lib/echarts.min.js',
            highcharts: '/modules/lib/highcharts.js',
            jquery: '/modules/lib/jquery.js',
            io: '/modules/lib/socket.io-1.4.5.js',
            vue: '/modules/lib/vue.js',
            zepto: '/modules/lib/zepto.js'
        }
    })
    // img
    .match('/images/**.png', {
        optimizer: fis.plugin('png-compressor')
    })
    .match('*.{png,jpg,gif,eot,svg,ttf,woff,woff2,ico}', {
        useHash: true
    })
    // js
    .match('*.js', {
        useHash: true,
        optimizer: uglifyPlugin
    })
    .match('/modules/lib/*.js', {
        parser: null,
        optimizer: null,
    })
    .match('*.blade.php:js', {
        optimizer: uglifyPlugin
    })
    .match('*.min.js', {
        optimizer: null
    })
    // css
    .match('*.{less,css}', {
        useHash: true,
        optimizer: fis.plugin('clean-css')
    })
    .match('*.blade.php:css', {
        optimizer: fis.plugin('clean-css')
    });

module.exports = fis;
