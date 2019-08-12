const funcionario = {nome: "Maria", salario: 9.249};
const clone = {ativo: true, ...funcionario};

console.log(clone);

const grupoA = ["João", "Pedro", "Daniel"];
const grupoFinal = ["Maria", "Alan", ...grupoA,"Leo"];

console.log(grupoA);
console.log(grupoFinal);