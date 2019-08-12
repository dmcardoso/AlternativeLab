exports.up = function (knex) {
    return knex.schema.createTable('categorias', function (table) {
        table.increments('id').primary();
        table.string('categoria', 255).notNullable();
    }).then(function () {
        return knex.schema.createTable('usuarios', function (table) {
            table.increments('id').primary();
            table.string('first_name', 255).notNullable();
            table.string('last_name', 255).notNullable();
            table.integer('categoria', 255).unsigned().notNullable();

            table.foreign('categoria').references('id').inTable('categorias');
        });
    });
};

exports.down = function (knex, Promise) {
    return Promise.all([
        knex.schema.dropTable('usuarios'),
        knex.schema.dropTable('categorias')
    ]);
};
