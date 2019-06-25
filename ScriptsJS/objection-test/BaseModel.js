const Knex = require('knex');
const { Model } = require('objection');
const { QueryBuilder } = require('./QueryBuilder');
const { Validator } = require('./Validator');
const knex_config = require('./knexfile');

const knex = new Knex(knex_config);

Model.knex(knex);

class BaseModel extends Model {
    static get QueryBuilder () {
        return QueryBuilder;
    }

    static get modelPaths () {
        return [__dirname];
    }

    static createValidator () {
        return new Validator();
    }
}

module.exports = { BaseModel };