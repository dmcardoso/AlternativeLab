const HtmlWebpackPlugin = require("html-webpack-plugin");

module.exports = (env = {}, argv = {}) => ({
    module: {
        rules: [
            {
                test: /\.js$/,
                use: "babel-loader"
            }
        ]
    },
    devtool: "source-map",
    plugins: [
        // Any option given to Webpack client can be captured on the "argv"
        argv.mode === "development" ? new HtmlWebpackPlugin() : null
    ].filter(
        // To remove any possibility of "null" values inside the plugins array, we filter it
        plugin => !!plugin
    )
});
