const expect = require('chai').expect;

const sum = require('./oldsum');

it('sum should be a function', () => {
    expect(sum).to.be.a('function');
});