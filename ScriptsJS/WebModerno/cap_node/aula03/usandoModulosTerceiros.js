//usar npm i lodash <- antes de rodar
/*usar npm i -g nodemon para instalar o nodemon e liberar o comando nodemon para
usar o runtime sempre que tiver alteração no arquivo*/
const _ = require('lodash');

setInterval(() => console.log(_.random(25, 50)), 2000);
const a = 6;
console.log(a);