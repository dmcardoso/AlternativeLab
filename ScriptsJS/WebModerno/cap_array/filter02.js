Array.prototype.filter2 = function(callback){
    let newArray = [];
    for(let i = 0; i < this.length; i++){
        if(callback(this[i], i, this)){
            newArray.push(this[i]);
        }
    }
    return newArray;
};

const produtos = [
    {nome: "Notebook", preco: 2499, fragil: true},
    {nome: "iPad pro", preco: 4199, fragil: true},
    {nome: "Copo de vidro", preco: 12.49, fragil: true},
    {nome: "Copo de plástico", preco: 18.99, fragil: false}
];

console.log(produtos.filter2(function (p) {
    return p.preco > 10;
}));

console.log(produtos.filter2(function (p) {
    return p.preco > 2400;
}));

console.log(produtos.filter2(function (p) {
    return p.preco > 2500;
}));

console.log(produtos.filter2(function (p) {
    return false;
}));

console.log(produtos.filter2(function (p) {
    return true;
}));

const frageis = p => p.fragil;
const caro = p => p.preco >= 500;

console.log(produtos.filter2(frageis).filter2(caro));