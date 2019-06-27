module.exports = (env = {}, argv = {}) => ({
    mode: argv.mode === 'development' ? 'development' : 'production',
    devServer: require('./webpack/module.devServer')(env, argv),
    optimization: require('./webpack/module.optimization')(env, argv),
    module: {
        rules: require('./webpack/module.rules')(env, argv),
    },
    devtool: argv.mode !== 'production' ? 'source-map' : 'cheap-module-source-map',
    plugins: require('./webpack/module.plugins')(env, argv),
});

