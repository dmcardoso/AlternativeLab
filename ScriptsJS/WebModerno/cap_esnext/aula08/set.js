const times = new Set();

times.add("Vasco");
times.add("Sao Paulo").add("Paleiras").add("Corinthians");
times.add("Flamengo");
times.add("Vasco");

console.log(times);
console.log(times.size);
console.log(times.has("vasco"));
console.log(times.has("Vasco"));
times.delete("Flamengo");
console.log(times);

const nomes = ['Raquel', "Lucas", "Júlia", "Lucas"];
const nomesSet = new Set(nomes);
console.log(nomesSet);
