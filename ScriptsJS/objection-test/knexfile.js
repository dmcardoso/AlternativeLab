// Update with your config settings.

module.exports = {
    client: 'mysql',
    connection: {
        database: 'objection',
        user: 'root',
        password: '1234'
    },
    pool: {
        min: 2,
        max: 10
    }
};
