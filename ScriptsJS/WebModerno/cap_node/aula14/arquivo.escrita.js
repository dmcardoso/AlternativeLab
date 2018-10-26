const fs = require('fs');

const produto = {
    nome: "Celular",
    preco: 1249.99,
    desconto: 0.15
};

fs.writeFile(__dirname + '/arquivogerado.json', JSON.stringify(produto), erro => {
    console.log(erro || "Arquivo salvo");
    // Para JSON dentro da callback pq é assincrono
    const config = require('./arquivogerado.json');
    console.log(config);
});

const caminho = __dirname + "/arquivogerado.json";

//assincrono
fs.readFile(caminho, 'utf-8', (err, conteudo) => {
    const config = JSON.parse(conteudo);
    console.log(config);
});



