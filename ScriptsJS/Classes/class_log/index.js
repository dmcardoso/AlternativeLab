const Log = require('./main');
const array = ["nome", ["outro", ["funciona?"]], "feijao"];
const obj = {
    nome: "Daniel",
    idade: 19,
    outro: "Programador"
};
const string = "Meu nome é Daniel";

const log = new Log(__dirname);
log.logD("obj", obj);
log.logD("array", array);
log.logD("string", string);