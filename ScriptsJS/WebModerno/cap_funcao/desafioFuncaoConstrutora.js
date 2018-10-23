const Pessoa = function(nome) {
    let nome_pessoa = nome;

    this.falar = () => {
        console.log(`Meu nome é ${nome_pessoa}`);
    };

    this.getNome = () => {
        return nome_pessoa;
    };
};

const p1 = new Pessoa("Daniel");
p1.falar();
console.log(p1.getNome());;
