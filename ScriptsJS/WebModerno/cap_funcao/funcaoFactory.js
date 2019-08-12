const criarProduto = function(nome, preco){
   return {
       nome,
       preco,
       desconto: 0.1
   }
};

console.log(criarProduto("Banana", "4,50"));
console.log(criarProduto("Feijao", "4,80"));