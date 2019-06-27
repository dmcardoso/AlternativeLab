const { output } = require('./module.paths');
const path = require('path');

module.exports = (env, args) => (
    {
        contentBase: path.join('./', output.outputPath),
        port: 9000
    }
);