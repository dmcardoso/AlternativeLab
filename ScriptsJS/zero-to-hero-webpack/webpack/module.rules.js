const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { output } = require('./module.paths');
const path = require('path');

module.exports = (env, argv) => [
    {
        test: /\.js$/,
        use: 'babel-loader'
    },
    {
        test: /\.(gif|png|jpe?g|svg)$/i,
        use: [
            {
                loader: 'file-loader',
                options: {
                    name: '[hash].[ext]',
                    outputPath: (url, resourcePath, context) => {
                        return path.join(output.images, `\\${url}`);
                    }
                }
            },
            {
                loader: 'image-webpack-loader',
                options: {
                    disable: true // Disables on development mode
                }
            }
        ]
    },
    {  // Audio
        test: /\.(ogg|mp3|wav|mpe?g)$/i,
        use: [
            {
                loader: 'file-loader',
                options: {
                    name: '[hash].[ext]',
                    outputPath: (url, resourcePath, context) => {
                        return path.join(output.audio, `\\${url}`);
                    }
                }
            }
        ]
    },
    {
        test: /\.(scss|css|sass)$/i,
        use: [
            argv.mode === 'production'
                ? MiniCssExtractPlugin.loader
                : 'style-loader',
            {
                loader: 'css-loader',
                options: {
                    sourceMap: true
                }
            },
            {
                loader: 'sass-loader',
                options: {
                    sourceMap: true
                }
            }
        ]
    }
];