const fs = require('fs');
const Json2csvTransform = require('json2csv').Transform;

// Options
const fields = ['nome', 'idade', 'turma'];
const delimiter = ";";
// const excelStrings = true;
const withBOM = true;
const opts = { fields , delimiter, withBOM};

const transformOpts = { highWaterMark: 16384, encoding: 'utf-8'};

const input = fs.createReadStream('./data.json', { encoding: 'utf8' });
const output = fs.createWriteStream('out.csv', { encoding: 'utf8' });
const json2csv = new Json2csvTransform(opts, transformOpts);

const processor = input.pipe(json2csv).pipe(output);

// You can also listen for events on the conversion and see how the header or the lines are coming out.
json2csv
    .on('header', header => console.log(header))
    .on('line', line => console.log(line))
    .on('error', err => console.log(err));
