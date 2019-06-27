const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = (env, args) => (
    {
        minimizer: [
            new TerserPlugin({
                cache: true,
                parallel: true,
                sourceMap: (args.mode !== 'production')
            }),
            new OptimizeCSSAssetsPlugin({})
        ]
    }
);