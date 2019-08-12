const fs = require('fs');
const path = require('path');
const Entities = require('html-entities').AllHtmlEntities;
const moment = require('moment');
moment.locale('pt-br');


const entities = new Entities();

let log_path = __dirname;

const TYPE_LOG = [
    {type: "d", color: "#535AFF", type_name: "Debug", associate: 'log.txt'},
    {type: "e", color: "#FF1A0A", type_name: "Error", associate: 'error_log.txt'}
];

// Configura o log
const renderLog = function (data) {
    let html = "";

    html += "<hr style='border: 0; border-bottom: 1px solid #ccc; background: #000; margin-bottom: 15px;'/>";
    html += `<h1 style="color: ${data.color};margin-top:0;margin-bottom:0;">${data.name}</h1>`;
    html += `<span>Tipo: ${data.type_data} | Tamanho: ${data.size} | ${data.date}</span>`;
    if (data.type_data === "Object" || data.type_data === "Array") {
        html += `<pre>${print_r(data.log)}</pre>`;
    } else {
        html += `<pre>${entities.encode(data.log)}</pre>`;
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
                    val2 = '\'' + entities.encode(val1) + '\'';
                    break;

                default:
                    val2 = entities.encode(val1);
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

const addLog = function (type, data) {
    const data_log = {};
    // Determina o tipo de dado
    if (Array.isArray(data)) {
        data_log.type_data = "Array";
        data_log.size = `${data.length} posi&ccedil;&otilde;es`;
    } else if (typeof data === 'object') {
        data_log.type_data = "Object";
        data_log.size = `${Object.keys(data).length} &iacute;ndices`;
    } else if (typeof data === 'string') {
        data_log.type_data = "String";
        data_log.size = `${data.length} caracteres`;
    }

    data_log.name = (type === "d") ? "Debug" : "Error";
    data_log.date = `Data do log: ${moment().format('LTS L')}`;
    data_log.log = data;

    return data_log;
};


const writeLog = function (data_log) {
    const file_name = data_log.associate;

    // Determina o caminho do arquivo
    const dest = path.resolve(log_path, file_name);

    // Escreve no final do arquivo
    fs.appendFile(dest, renderLog(data_log), erro => {
        const msg_log = (erro) ? `Log ${data_log.name} não gerado: ${erro}` : `Log ${data_log.name} gerado`;
    });
};

const Log = function () {

    // Para pegar a raiz do projeto, voltando da pasta do repo e da node_modules
    log_path = path.resolve(__dirname, '../../');

    const data_log = {};

    String.prototype.log = function (type) {
        Object.assign(data_log, addLog(type, this.concat('')), getTypeLog(type));

        writeLog(data_log);
    };

    Object.prototype.log = function (type) {
        Object.assign(data_log, addLog(type, this), getTypeLog(type));

        writeLog(data_log);
    };

    Array.prototype.log = function (type) {
        Object.assign(data_log, addLog(type, this), getTypeLog(type));

        writeLog(data_log);
    };

};

//Classe auto invocada
module.exports = new Log();