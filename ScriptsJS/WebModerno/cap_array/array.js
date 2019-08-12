console.log(typeof Array, typeof new Array, typeof []);

let aprovados = new Array("Bia", "Carlos", "Ana");

console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
console.log(aprovados[0]);
console.log(aprovados[1]);
console.log(aprovados[2]);
console.log(aprovados[3]);

aprovados[3] = "Paulo";

console.log(aprovados[3]);

aprovados.push("Augusto");

console.log(aprovados[4]);

aprovados[9] = "Abia";
console.log(aprovados.length);
console.log(aprovados);
aprovados.sort();
console.log(aprovados);

delete aprovados[1];
console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
aprovados.splice(1,1);
console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
aprovados.splice(1,2);
console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
aprovados.splice(1,2, "Elemento 2", "Elemento 1");
console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
aprovados.splice(1,0, "Elemento 2", "Elemento 1");
console.log(aprovados);

aprovados = ["Bia", "Carlos", "Ana"];
aprovados.splice(aprovados.length,0, "Elemento 2", "Elemento 1");
console.log(aprovados);