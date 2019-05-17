exports.up = function(knex) {
    return knex.schema.createTable('usuario', function(table){
        table.increments('id').primary();
        table.string('first_name', 255).notNullable();
        table.string('last_name', 255).notNullable();
    });
};

exports.down = function(knex, Promise) {
    return knex.schema.dropTable('usuario');
};
