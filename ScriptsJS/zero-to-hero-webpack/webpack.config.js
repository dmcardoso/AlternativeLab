module.exports = (env = {}, argv = {}) => ({
    module: {
        rules: require('./webpack/module.rules')(env, argv),
    },
    devtool: 'source-map',
    plugins: require('./webpack/module.plugins')(env, argv),
});
