{
    let a = 4;
    let b = 5;
    console.log(a, b);
}

// Pelo escopo de bloco não funciona
// console.log(a, b);


//Template string
const produto = 'iPad';
console.log(`${produto} é caro!`);

//Destructuring
const [l, e, ...tras] = "Cod3r";

console.log(l, e, tras.join(''));

const [x, ,y] = [1,2,3];
console.log(x, y);

const {idade: i, nome} = {nome: "Daniel", idade: 9};

console.log(i, nome);