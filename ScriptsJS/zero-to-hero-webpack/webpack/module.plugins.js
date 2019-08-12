const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
const path = require('path');
const {output} = require('./module.paths');

module.exports = (env, argv) => [
    // Any option given to Webpack client can be captured on the "argv"
    argv.mode === 'development' ? new HtmlWebpackPlugin() : null,
    env.analyse ? new BundleAnalyzerPlugin() : null,
    argv.mode === 'production' ?
        new MiniCssExtractPlugin({
            filename: path.join(output.css, '\\[name].css'),
            chunkFilename: path.join(output.css, '\\[id].css')
        }) : null
].filter(
    // To remove any possibility of "null" values inside the plugins array, we filter it
    plugin => !!plugin
);