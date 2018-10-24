const alunos = [
    {nome: "João", nota: 7.3, bolsista: false},
    {nome: "Maria", nota: 9.3, bolsista: true},
    {nome: "Pedro", nota: 9.8, bolsista: false},
    {nome: "Daniel", nota: 8.7, bolsista: true}
];

//Desafio 1: Todos os alunos são bolsistas?
const todosBolsistas = alunos.map(e => e.bolsista).reduce((anterior, atual) => {
    // console.log(anterior, atual);
    return anterior && atual;
});
console.log(todosBolsistas);


//Desafio 2: Algum aluno é bosista?
const algumBolsista = alunos.map(e => e.bolsista).reduce((anterior, atual) => {
    // console.log(anterior, atual);
    return anterior || atual;
});
console.log(algumBolsista);