const moduloA = require('../../moduloA');
console.log(moduloA);

const c = require('./pasta_c');
console.log(c);

const http = require('http');
http.createServer((req, res) =>{
    res.write("Bom dia");
    res.end();
}).listen(8080);