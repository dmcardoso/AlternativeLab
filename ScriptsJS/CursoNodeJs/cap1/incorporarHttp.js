const http = require('http');

http.createServer((req, res) => {
    res.end('<h1>Portal de notícias</h1>');
}).listen(3000);

// Ou
//
// const server = http.createServer((req, res) => {
//     res.end('<h1>Portal de notícias</h1>');
// });
//
// server.listen(3000);