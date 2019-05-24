const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env = {}, argv = {}) => ({
    module: {
        rules: require('./webpack/module.rules')(env, argv),
    },
    devtool: 'source-map',
    plugins: [
        // Any option given to Webpack client can be captured on the "argv"
        argv.mode === 'development' ? new HtmlWebpackPlugin() : null,
        argv.mode === 'production' ?
            new MiniCssExtractPlugin({
                filename: '[name].css',
                chunkFilename: '[id].css'
            }) : null
    ].filter(
        // To remove any possibility of "null" values inside the plugins array, we filter it
        plugin => !!plugin
    )
});
