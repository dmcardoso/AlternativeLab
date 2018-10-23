const obj = {
    nome: "Rebeca",
    idade: 2,
    peso: 13
};

console.log(Object.keys(obj));
console.log(Object.values(obj));
console.log(Object.entries(obj));

Object.entries(obj).forEach(e => {
    console.log(`${e[0]}: ${e[1]}`);
});

//Destructing
Object.entries(obj).forEach(([chave, valor]) => {
    console.log(`${chave}: ${valor}`);
});

Object.defineProperty(obj, "dataNascimento", {
    enumerable: true,
    writable: false,
    value: "06/01/1999"
});

obj.dataNascimento = "06/02/1999";

console.log(obj);
console.log(obj.dataNascimento);
console.log(Object.keys(obj));

//Object assign ES2015
const dest = {a: 1}, o1 = {b: 2}, o3 = {c: 3, a: 4};

Object.assign(dest, o1, o3);
console.log(dest);