function Aula(nome, videoID) {
    this.nome = nome;
    this.videoID = videoID;
}

const aula01 = new Aula("Bem vindo", 123);
const aula02 = new Aula("Até breve", 456);

console.log(aula01, aula02);

function novo(f, ...params){
    const obj = {};
    obj.__proto__ = f.prototype;
    f.apply(obj, params);
    return obj;
}

const aula3 = novo(Aula, "Nova aula", 789);
const aula4 = novo(Aula, "Aula nova", 147);
console.log(aula3, aula4);