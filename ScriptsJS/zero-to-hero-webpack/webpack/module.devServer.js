const { output } = require('./module.paths');
const path = require('path');

module.exports = (env, args) => (
    {
        contentBase: path.join('./', output.outputPath),
        port: 9000,
        // index: 'index.html',
        // liveReload: false,
        // open: true, || open: 'Google Chrome'
        // overlay: true,
        // proxy: {
        //     '/api': 'http://localhost:3000'
        // },
    }
);