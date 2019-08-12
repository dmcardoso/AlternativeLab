class Lancamento {
    constructor(nome = "Genérico", valor = 0) {
        this.nome = nome;
        this.valor = valor;
    }
}

class CicloFincaneiro {
    constructor(mes, ano) {
        this.mes = mes;
        this.ano = ano;
        this.lancamentos = [];
    };

    addLancamentos(...lancamentos) {
        lancamentos.forEach(l => this.lancamentos.push(l));
    };

    sumario() {
        let valorCosolidado = 0;
        this.lancamentos.forEach(l => {
            valorCosolidado += l.valor;
        });
        return valorCosolidado;
    };
}

const salario = new Lancamento("Salario", 45000);
const contaDeLuz = new Lancamento("Luz", -220);

const contas = new CicloFincaneiro(10, 2018);
contas.addLancamentos(salario, contaDeLuz);
console.log(contas.sumario());