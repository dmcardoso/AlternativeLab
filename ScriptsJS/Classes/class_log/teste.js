const moment = require('moment');

moment.locale('pt-br');
console.log(moment().format('L LTS'));