const fs = require('fs');
const path = require('path');

// Zera o conteúdo do arquivo
fs.writeFile('./log.txt', '', (err) => {
    if (err) throw err;
    console.log('The file has been saved!');
});

let data_file_length = 0;

fs.watchFile('./log.txt', (curr, prev) => {
    // console.log(curr);
    // console.log(prev);
    fs.readFile('./log.txt', 'utf8', (err, data) => {
        if (err) throw err;
        console.log(data.substr(data_file_length));
        data_file_length = data.length;
    });
});
