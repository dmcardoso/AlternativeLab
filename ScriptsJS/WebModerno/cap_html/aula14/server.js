const porta = 3003;
const express = require('express');
const app = express();
const bodyParser = require('body-parser');

app.use(bodyParser.urlencoded({extended: true}));

app.post('/usuarios', (req, res) => {
    console.log(req.body);
    res.send("<h1>Parabéns. Usuário incluído</h1>");
});

//Pegar por get
app.get('/usuarios', (req, res) => {
    console.log(req.body);
    console.log(req.query);
    res.send("<h1>Parabéns. Usuário incluído</h1>");
});

app.post('/usuarios/:id', (req, res) => {
    console.log(req.params.id);
    console.log(req.body);
    res.send("<h1>Parabéns usuário alterado!</h1>");
});

app.listen(porta);
