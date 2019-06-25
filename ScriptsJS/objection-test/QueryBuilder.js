const { QueryBuilder: QueryBuilderObjection } = require('objection');

class QueryBuilder extends QueryBuilderObjection {
    findById (model) {
        if (model.id) {
            return this.select().where('id', model.id);
        }else {
            throw "Id é obgigatório!";
        }
    }
}

module.exports = {QueryBuilder};