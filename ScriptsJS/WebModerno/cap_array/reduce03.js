Array.prototype.reduce2 = function (callback, inicial) {
    const indiceInicial = inicial ? 0 : 1;
    let acumulador = (inicial !== undefined) ? inicial : this[0];
    for(let i = indiceInicial; i < this.length; i++){
        acumulador = callback(acumulador, this[i], i, this);
    }
    return acumulador;
};

const alunos = [
    {nome: "João", nota: 7.3, bolsista: true},
    {nome: "Maria", nota: 9.3, bolsista: true},
    {nome: "Pedro", nota: 9.8, bolsista: true},
    {nome: "Daniel", nota: 8.7, bolsista: true}
];

//Desafio 1: Todos os alunos são bolsistas?
const todosBolsistas = alunos.map(e => e.bolsista).reduce2((anterior, atual) => {
    // console.log(anterior, atual);
    return anterior && atual;
}, false);
console.log(todosBolsistas);


//Desafio 2: Algum aluno é bosista?
const algumBolsista = alunos.map(e => e.bolsista).reduce2((anterior, atual) => {
    // console.log(anterior, atual);
    return anterior || atual;
});
console.log(algumBolsista);

const resultado = alunos.map(a => a.nota).reduce2(function (acumulador, atual) {
    // console.log(acumulador, atual);
    return acumulador + atual
}, 20);
console.log(resultado);