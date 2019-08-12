function naofalarDepoisDe(segundos, frase) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            reject(frase);
        }, segundos * 1000);
    });
}

function falarDepoisDe(segundos, frase) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve(frase);
        }, segundos * 1000);
    });
}

falarDepoisDe(3, "Oi essa é uma promise")
    .then(frase => frase.concat('!?!?'))
    .then(outraFrase => console.log(outraFrase))
    .catch(e => console.log(e));

naofalarDepoisDe(3, "Oi essa é uma promise")
    .then(frase => frase.concat('!?!?'))
    .then(outraFrase => console.log(outraFrase))
    .catch(e => console.log(e));