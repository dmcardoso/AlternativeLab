const webpack = require('webpack');
const path = require('path');

module.exports = {
    entry: path.join(__dirname, 'src', 'index'),
    output:{
        path: path.join(__dirname, 'dist'),
        filename: 'bundle.js',
    },
    devServer: {
        contentBase: "./dist",
        port: 9000
    }
};