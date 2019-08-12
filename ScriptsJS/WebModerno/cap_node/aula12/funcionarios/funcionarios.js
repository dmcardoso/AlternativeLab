const url = "http://files.cod3r.com.br/curso-js/funcionarios.json";
const axios = require('axios');

axios.get(url).then(response => {
    const funcionarios = response.data;
    // console.log(funcionarios);

    //Filtrar os chineses
    const chineses = funcionario => funcionario.pais === "China";
    // console.log(funcionarios.filter(chineses));

    //Filtrar as mulheres
    const chinesas = funcionaria => funcionaria.genero === "F";
    // console.log(funcionarios.filter(chineses).filter(chinesas));

    //Filtrar com o menor salário
    const menor_salario = (antigo, atual) => {
        return antigo.salario < atual.salario ? antigo : atual;
    };

    //Filtrar maior salário
    const maior_salario = (antigo, atual) => {
        return antigo.salario > atual.salario ? antigo : atual;
    };
    let resultado = funcionarios.filter(chineses).filter(chinesas).reduce(menor_salario);
    console.log(resultado);
    resultado = funcionarios.filter(chineses).filter(chinesas).reduce(maior_salario);
    console.log(resultado);
});