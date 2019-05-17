const db = require('./config/db');

const usuario = [
    {first_name: 'Daniel', last_name: "Moreira Cardoso"},
    {first_name: 'Daniela', last_name: "Moreira Cardoso"},
    {first_name: 'Daniele', last_name: "Moreira Cardoso"},
];

// db('usuario').insert(usuario).then(data => console.log(data));

let query = db.select('*').from('usuario');

query.where('first_name', 'like', '%Daniel%');

query.then(result => {
    result.forEach((v, i) => {
        console.log(i, v);
    })
});