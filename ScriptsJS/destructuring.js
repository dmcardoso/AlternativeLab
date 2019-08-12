const obj = {
    nome: "Daniel",
    idade: 19,
    namorada: "Lainieles",
    comida: "Strogonoff"
};

function spread({nome, ...outros}){
    console.log(`Nome: ${nome}`);
    console.log(outros);
}

spread(obj);