function getPreco(imposto = 0, moeda = 'R$'){
    return `${moeda} ${this.preco * (1 - this.desc) * (1 + imposto)}`;
}

const produto = {
    preco: 4589,
    desc : 0.15,
    nome : "Notebook",
    getPreco
};

global.preco = 20;
global.desc = 0.1;

console.log(getPreco());
console.log(produto.getPreco());
console.log(produto);

const carro = {
    preco: 49990,
    desc : 0.20
};

console.log(getPreco.call(carro));
console.log(getPreco.apply(carro));

console.log(getPreco.call(carro, 0.17, '$'));
console.log(getPreco.apply(carro, [0.17, '$']));