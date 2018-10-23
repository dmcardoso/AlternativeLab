const produto = Object.preventExtensions({
    nome: "Notebook",
    preco: 4999,
    tag: "promocao"
});

console.log("Extensível: ", Object.isExtensible(produto));

produto.nome = "Borracha";
delete produto.tag;
produto.descricao = "Borracha preta";
console.log(produto);

const pessoa = {nome: "Daniel Moreira", idade: 19};
Object.seal(pessoa);
console.log("Selado: ", Object.isSealed(pessoa));

pessoa.nome = "Gabriel";
delete pessoa.idade;
pessoa.descricao = "Irmão do Daniel";
console.log(pessoa);

const empresa = {nome: "Núcleo", funcionarios: 17};
Object.freeze(empresa);

empresa.nome = "Everaldo pitdog";
empresa.renda = 4888;
delete empresa.funcionarios;
console.log("Selado: ", Object.isSealed(empresa));
console.log("Extensível: ", Object.isExtensible(empresa));
console.log(empresa);

