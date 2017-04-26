var webpack = require("webpack");
var jQuery = require("jquery");
var path = require("path");

module.exports = {
    externals: {
        "jquery": "jQuery"
    },
    resolve: {
        modules: [
            path.resolve('./resources/js/modules/'),
            path.resolve('./node_modules')
        ]
    },
    module: {
        preLoaders: [
            {
                test: /\.js$/,
                loader: "eslint-loader",
                exclude: /node_modules/,
            }
        ],
        loaders: [
            {
                test: /\.js$/,
                loader: 'buble'
            }
        ]
    },
    eslint: {
        formatter: require("eslint/lib/formatters/stylish"),
        emitError: true,
        emitWarning: true,
        failOnError: true,
        failOnWarning: true,
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            compress: {warnings: false},
            sourceMap: true
        })
    ],
    devtool: "source-map"
}
