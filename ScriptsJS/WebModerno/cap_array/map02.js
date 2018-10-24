const carrinho = [
    '{"nome": "Borracha", "preco": 3.45}',
    '{"nome": "Caderno", "preco": 13.90}',
    '{"nome": "Kit de Lápis", "preco": 41.22}',
    '{"nome": "Caneta", "preco": 7.5}'
];

// console.log(carrinho);

// console.log(JSON.parse(carrinho[0]));


//meu
let resultado = carrinho.map(e => {
    return Object.values(JSON.parse(e))[1];
});

console.log(resultado);


//da aula

const paraObjeto = json => JSON.parse(json);

const apenasPreco = produto => produto.preco;

resultado = carrinho.map(paraObjeto).map(apenasPreco);
console.log(resultado);