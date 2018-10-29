const anonimo = process.argv.indexOf("-a") !== -1;

console.log(anonimo);

if(anonimo){
    process.stdout.write(`Fala anônimo!\n`);
    process.exit();
}else{
    process.stdout.write("Informe seu nome: ");
    process.stdin.on('data', data =>{
        //Não consegui tirar o espaço no final
        console.log(data.toString().replace("\n", ""));
        const nome = data.toString();

        process.stdout.write(`Fala ${nome}!!\n`);
        process.exit();
    })
}