const fs = require('fs');
const path = require('path');
const util = require('util');

let log_path = __dirname;

const TYPE_LOG = [
    {type: "d", color: "#535AFF", name: "Debug", associate: 'log.txt'},
    {type: "e", color: "#FF1A0A", name: "Error", associate: 'error_log.txt'}
];

// Configura o log
const renderLog = function (data) {
    let html = "";

    html += "<br><hr style='border: 0; border-bottom: 1px solid #ccc; background: #000;'/><br>";
    html += `<h1 style="color: ${data.color}">${data.name}</h1>`;
    html += `<span>Tipo: ${data.type_data} | Tamanho: ${data.size} | ${data.date}</span><br>`;
    if (data.type_data === "Object" || data.type_data === "Array") {
        html += `<pre>${print_r(data.log)}</pre>`;
    } else {
        html += `<pre>${data.log}</pre>`;
    }

    return html;
};

const print_r = function (obj, t) {
    // define tab spacing
    const tab = t || '';

    // check if it's array
    const isArr = !!Array.isArray(obj);

    // use {} for object, [] for array
    let str = isArr ? ('Array\n' + tab + '[\n') : ('Object\n' + tab + '{\n');

    // walk through it's properties
    for (let prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            const val1 = obj[prop];
            let val2 = '';
            const type = Object.prototype.toString.call(val1);
            switch (type) {

                // recursive if object/array
                case '[object Array]':
                case '[object Object]':
                    val2 = print_r(val1, (tab + '\t'));
                    break;

                case '[object String]':
                    val2 = '\'' + val1 + '\'';
                    break;

                default:
                    val2 = val1;
            }
            str += tab + '\t' + prop + ' => ' + val2 + ',\n';
        }
    }

    // remove extra comma for last property
    str = str.substring(0, str.length - 2) + '\n' + tab;

    return isArr ? (str + ']') : (str + '}');
};

const getTypeLog = function (type) {
    return TYPE_LOG.filter(type_log => type_log.type === type)[0];
};

const Log = function (path) {
    log_path = path;
    this.logD = function (name, data) {
        const data_log = {};

        // Determina o tipo de dado
        if (Array.isArray(data)) {
            data_log.type_data = "Array";
            data_log.size = data.length;
        } else if (typeof data === 'object') {
            data_log.type_data = "Object";
            data_log.size = Object.keys(data).length;
        } else if (typeof data === 'string') {
            data_log.type_data = "String";
            data_log.size = `${data.length} caracteres`;
        }

        // Junta o objeto com as propiedades do tipo de log
        Object.assign(data_log, getTypeLog("d"));

        data_log.date = `Data do log: ${new Date().toLocaleString('pt-BR')}`;
        data_log.log = data;

        console.log(data_log);

        writeFile(data_log);
    };
};


const writeFile = function (data_log) {
    const file_name = data_log.associate;

    // Determina o caminho do arquivo
    const dest = path.resolve(log_path, file_name);

    // Escreve no final do arquivo
    fs.appendFile(dest, renderLog(data_log), erro => {
        const msg_log = (erro) ? `Log ${data_log.name} não gerado: ${erro}` : `Log ${data_log.name} gerado`;
        console.log(msg_log);
    });
};

module.exports = Log;