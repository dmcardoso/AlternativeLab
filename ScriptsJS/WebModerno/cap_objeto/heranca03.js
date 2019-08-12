const pai = {nome: "Everaldo", corCabelo: "careca"};

const filho1 = Object.create(pai);
filho1.nome = "Daniel";
console.log(filho1.corCabelo);

const filho2 = Object.create(pai, {
    nome: {value: "Gabriel", writable: false, enumerable: true}
});

console.log(filho2.nome);
filho2.nome = "Daniel";
console.log(`${filho2.nome} tem cabelo ${filho2.corCabelo}`);

console.log(Object.keys(filho1));
console.log(Object.keys(filho2));

for (let key in filho2){
    console.log(key);
}
for (let key in filho2){
    filho2.hasOwnProperty(key) ? console.log(key) : console.log(`Por herança: ${key}`);
}