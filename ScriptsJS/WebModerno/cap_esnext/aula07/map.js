const tecnologias = new Map();

tecnologias.set('react', {framework: false});
tecnologias.set('angular', {framework: true});

console.log(tecnologias);
console.log(tecnologias.react);
console.log(tecnologias.get('react'));
console.log(tecnologias.get('react').framework);

const chavesVariadas = new Map([
    [function(){}, "Função"],
    [{}, "Objeto"],
    [123, "Número"]
]);

console.log(chavesVariadas);

chavesVariadas.forEach((v1, ch) => {
    console.log(ch, v1);
});

console.log(chavesVariadas.has(123));
console.log(chavesVariadas.delete(123));
console.log(chavesVariadas);

chavesVariadas.set(123, "a");
chavesVariadas.set(123, "b");

console.log(chavesVariadas);
console.log(chavesVariadas);

chavesVariadas.set(1234, "a");
chavesVariadas.set(12345, "b");

console.log(chavesVariadas);