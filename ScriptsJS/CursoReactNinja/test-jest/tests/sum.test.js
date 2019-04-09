describe('# ESCOPO', () => {
    it('Testando jest', () => {});
    it('Testando jest 2', () => {});
});

describe('# ESCOPO 2', () => {
    it('Testando jest', () => {});
    it('Testando jest 2', () => {});
});

console.assert(1 === 2, '1 não é igual a 2');

it('1 é igual a 1', () => {
    console.assert(1 === 1, '1 não é igual a 1');
});
it('1 é igual a 1', () => {
    expect(1).toBe(2);
});