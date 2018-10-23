class Avo{
    constructor(sobrenome) {
        this.sobrenome = sobrenome;
    }
}

class Pai extends Avo{
    constructor(sobrenome, profissao = "Professor"){
        super(sobrenome);
        this.profissao = profissao;
    }
}

class Filho extends Pai{
    constructor(sobrenome = "Silva", profissao){
        super(sobrenome, profissao);
    }
}

const filho = new Filho("Moreira", "Desenvolvedor Web");
const filho1 = new Filho();


console.log(filho);
console.log(filho1);