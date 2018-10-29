// Arrow Function
const soma = (a,b) => a + b;

console.log(soma(2, 3));

// This nas arrow functions
const lexico1 = () => console.log(this === exports);
const lexico2 = lexico1.bind({});

lexico1();
lexico2();

// Parâmetros Default
function log(texto = "Node"){
    console.log(texto);
}

log();
log("Arrow function");

// Operador rest
function total(...numeros){
    let total = 0;
    numeros.forEach(n => total += n);
    return total;
}

console.log(total(2,3,4,5));