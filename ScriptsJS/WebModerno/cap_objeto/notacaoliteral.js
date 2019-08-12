const a = 5;
const b = 6;
const c = 7;

const obj1 = {a: a, b: b, c: c};
const obj2 = {a,b,c};

console.log(obj1, obj2);

const indice_attr = "nome";
const valor_attr = 7;

const obj3 = {};
obj3[indice_attr] = valor_attr;
console.log(obj3);

const obj4 = {[indice_attr]: valor_attr};
console.log(obj4);

const obj5 = {
    funcao1: function () {

    },
    funcao2: function () {

    }
};

console.log(obj5);