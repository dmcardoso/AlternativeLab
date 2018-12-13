const express = require('express');
const app = express();
const saudacao = require('./saudacaomid');


app.use('/opa', (req, res, next) => {
    console.log("Antes...");
    next();
});

app.use(saudacao("Daniel"));


// Maneira difícil
app.post('/corpo', (req, res) => {
    let corpo = "";
    req.on('data', function(parte){
        corpo += parte;
    });

    req.on('end', function () {
       // res.send(corpo);
       res.json(JSON.parse(corpo));
    });
});

app.get('/clientes/relatorio', (req, res) => {
    res.send(`Cliente relatório: completo = ${req.query.completo} ano = ${req.query.ano}`);
});

app.get('/clientes/:id', (req, res) => {
    res.send(`Cliente ${req.params.id} selecionado`);
});

app.get('/opa', (req, res) => {
    console.log("Durante...");
    res.json({
        data: [
            {
                id: 7, name: "Ana", position: 1
            },
            {
                id: 34, name: "Bia", position: 2
            },
            {
                id: 73, name: "Carlos", position: 3
            }
        ],
        count: 30,
        skip: 0,
        limit: 3,
        status: 200
    });

    // res.json({
    //    name: "iPad 32gb",
    //    price: 1899,
    //    discount: 0.12
    // });
});


app.use('/opa', (req, res, next) => {
    console.log("Depois...");
    next();
});

app.listen(3000, () => {
    console.log("Backend executando");
});