const { Categorias, Usuarios } = require('./config.db');

const insert = async () => {

    // const category = await Categorias.query().insert({categoria: 'administrador'}).catch(e => console.log(e));

    const user = await Usuarios.query().insert({
        first_name: 'Aliberto',
        last_name: 'Neto',
        categoria: 1
    })
        .then(res => {
            console.log('aqui');
            console.log(res);
        }).catch(e => {
            console.log('aquiiiiii');
            console.log('error', e);
        });


};

const select = async () => {

    // const users = await Usuarios.query().select('*', 'c.id as categoria_id').joinRelation('categorias', { alias: 'c' }).where('c.id', '2');
    // console.log(users);

    // const users = await Usuarios.query().findById({id: 2});
    // console.log(Usuarios.columnNameMappers);

    // console.log(new Usuarios);

    // const categories = await Categorias.query().select('u.*').joinRelation('usuarios', { alias: 'u' }).where('u.categoria', '1');
    // console.log(categories);

};

insert();

// select();