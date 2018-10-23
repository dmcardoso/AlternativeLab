//Criação literal
const obj_literal = {};

console.log(typeof obj_literal, obj_literal);

//Objetos com JS
const obj_js = new Object();
console.log(typeof obj_js, obj_js, typeof Object, typeof new Object());

//Funções construtoras
function Produto(nome, preco, desc) {
    this.nome = nome;
    this.getValorComDesconto = () => {
        return preco * (1 - desc);
    }
}

const p1 = new Produto("Notebook", 4650, 0.1);
const p2 = new Produto("Carro", 45550, 0.2);

console.log(p1.getValorComDesconto());
console.log(p2.getValorComDesconto());

//Função factory
function criarFuncionario(nome, salarioBase, faltas) {
    return {
        nome,
        salarioBase,
        faltas,
        getSalario(){
            return (salarioBase / 30) * (30 - faltas)
        }
    };
}

const f1 = criarFuncionario("Daniel", 10000, 1);
const f2 = criarFuncionario("Daniel", 10000, 7);

console.log(f1.getSalario().toFixed(2), f2.getSalario());

//Object create
const filha = Object.create(null);
filha.nome = "Ana";
console.log(filha);

//Forma famosa JSON.parse
const fromJson = JSON.parse('{"info": "informação"}');

console.log(fromJson);