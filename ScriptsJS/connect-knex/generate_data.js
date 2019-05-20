process.stdin.setEncoding('utf8');
const moment = require('moment');
const readLine = require('readline-sync');

const nomes = ['Daniel', 'Leo', 'Aliberto', 'Marco', 'João'];
const sobrenome = ['Moreira', 'Leles', 'Neto', 'Aurélio', 'Alves', 'Cardoso', 'Ribeiro', 'Costa'];

const getQuantidadeDados = () => {
    return readLine.question('Quantos usuários deseja inserir? ');
};

const filterUsersNames = (user, list) => {
    return list.filter(row => row.name === user.name);
};

const users = [];

for(let i = 6; i > 0; i--){

    const random_index = Math.floor(Math.random() * (nomes.length - 0) - 0);



}
// console.log(getQuantidadeDados());