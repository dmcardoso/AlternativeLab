const fs = require('fs');
const path = require('path');

// Zera o conteúdo do arquivo
// fs.writeFile('./log.txt', '', (err) => {
//     if (err) throw err;
//     console.log('The file has been saved!');
// });


// this.data_file_length = 0;
//
// fs.watch(path.resolve(__dirname, 'log.txt'), function (event) {
//
//     if (event === 'change') {
//         fs.readFile(path.resolve(__dirname, 'log.txt'), 'utf8', (err, data) => {
//             if (err) throw err;
//                 const inicioString = this.data_file_length || 0;
//                 this.data_file_length = data.length;
//                 console.log(data.substring(inicioString, data.length));
//                 console.log(inicioString);
//                 console.log(this.data_file_length + "<");
//         });
//     }
//
// });

const watch = require('node-watch');
const readCache = require('read-cache');

let contador = 0;

const read = () => {
    readCache(path.resolve(__dirname, 'log.txt')).then(function (contents) {
        contents = contents.toString();
        console.log(contents.substr(contador, contents.length));
        contador = contents.length;
    });
};


const watcher = watch(path.resolve(__dirname, 'log.txt'), {recursive: true}, function (evt, name) {
    read();
    if (evt === "update") {
        read();
    }
});

// watcher.close();



