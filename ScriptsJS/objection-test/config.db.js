const Knex = require('knex');
const { Model } = require('objection');
const knex_config = require('./knexfile');

const knex = new Knex(knex_config);

Model.knex(knex);

class Usuarios extends Model {
    static get tableName () {
        return 'usuarios';
    }

    static get idColumn () {
        return 'id';
    }

    // Optional JSON schema. This is not the database schema!
    // No tables or columns are generated based on this. This is only
    // used for input validation. Whenever a model instance is created
    // either explicitly or implicitly it is checked against this schema.
    // See http://json-schema.org/ for more info.
    static get jsonSchema () {
        return {
            type: 'object',
            required: ['first_name', 'last_name', 'categoria'],
            // first_name
            // last_name
            // categoria
            properties: {
                id: { type: 'integer' },
                first_name: { type: 'string', minLength: 1, maxLength: 255 },
                last_name: { type: 'string', minLength: 1, maxLength: 255 },
                categoria: { type: 'number' },
            }
        };
    }

    static get relationMappings () {
        return {
            categorias: {
                relation: Model.BelongsToOneRelation,
                modelClass: Categorias,
                join: {
                    from: 'categorias.id',
                    to: 'usuarios.categoria'
                }
            }
        };
    }
}

class Categorias extends Model {
    static get tableName () {
        return 'categorias';
    }

    static get idColumn () {
        return 'id';
    }

    // Optional JSON schema. This is not the database schema!
    // No tables or columns are generated based on this. This is only
    // used for input validation. Whenever a model instance is created
    // either explicitly or implicitly it is checked against this schema.
    // See http://json-schema.org/ for more info.
    static get jsonSchema () {
        return {
            type: 'object',
            required: ['categoria'],
            properties: {
                id: { type: 'integer' },
                categoria: { type: 'string', minLength: 1, maxLength: 255 }
            }
        };
    }
}

module.exports = { Categorias, Usuarios };