var path = require('path');
var VueLoaderPlugin = require('vue-loader/lib/plugin');
var webpack = require('webpack');

const bundlesConfig = {
    entry: {
        'activeplayers': './web/app/themes/tclievelde/assets/js/activeplayers.js',
        'uploads': './web/app/themes/tclievelde/assets/js/uploads.js',
        'competition': './web/app/themes/tclievelde/assets/js/competition.js',
        'news': './web/app/themes/tclievelde/assets/js/news.js'
    },
    mode: 'development',
    output: {
        path: path.resolve(__dirname, 'web/app/themes/tclievelde/assets/js/bundles'),
        filename: '[name].bundle.js',
    },
    target: 'web',
    watch: false,
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
        },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
        },
        ],
    },
    plugins: [
        // make sure to include the plugin!
        new VueLoaderPlugin()
    ],
    stats: {
        colors: true,
    },
};


const globalConfig = {
    entry: {
        'global': './assets/js/global.js',
    },
    mode: 'development',
    output: {
        path: path.resolve(__dirname, 'web/app/themes/tclievelde/assets/js/bundles'),
        filename: 'global.bundle.js',
        library: 'Tclievelde'
    },
    target: 'web',
    watch: false,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
    stats: {
        colors: true,
    },
};

module.exports = [bundlesConfig, globalConfig];
