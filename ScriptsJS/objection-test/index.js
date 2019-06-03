const { Categorias, Usuarios } = require('./config.db');

const insert = async () => {

    // const category = await Categorias.query().insert({categoria: 'administrador'});

    const user = await Usuarios.query().insert({
        first_name: 'Aliberto',
        // last_name: 'Neto',
    }).then(res => {
        console.log(res);
    }).catch(e => {
        console.log('error',e.data.last_name);
    });

};

const select = async () => {

    const users = await Usuarios.query().select('*', 'c.id as categoria_id').joinRelation('categorias', { alias: 'c' }).where('c.id', '2');
    console.log(users);


    // const categories = await Categorias.query().select('u.*').joinRelation('usuarios', { alias: 'u' }).where('u.categoria', '1');
    // console.log(categories);


};

insert();
// select();