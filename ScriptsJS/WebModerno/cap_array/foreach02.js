Array.prototype.forEach2 = function(callback){
    for(let i = 0; i < this.length; i++){
        callback(this[i], i, this);
    }
};

const aprovados = ["Ana", "Daniel", "Bia", "Gustavo", "Heitor"];

aprovados.forEach2(function (valor, indice, array) {
    console.log(`${indice + 1}: ${valor}`);
    console.log(array);
});