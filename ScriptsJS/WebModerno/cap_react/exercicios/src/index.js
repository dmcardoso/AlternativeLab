import React from 'react';
import ReactDOM from 'react-dom';
// import Pessoa from './componentes/Pessoa';
// import Bomdia from './componentes/BomDia';
// import {BoaNoite, BoaTarde} from "./componentes/Multiplos";
// import Multi from "./componentes/Multiplos";
// import Saudacao from './componentes/Saudacao';
import Pai from './componentes/Pai';
import Filho from './componentes/Filho';

// ReactDOM.render(<Bomdia nome="Guilherme" idade={10}/>, document.getElementById('root'));

// ReactDOM.render(
//     <div>
//         <BoaNoite nome="Ana"/>
//         <BoaTarde nome="Bia"/>
//     </div>
// , document.getElementById('root'));

// ReactDOM.render(
//     <div>
//         <Multi.BoaNoite nome="Ana"/>
//         <Multi.BoaTarde nome="Bia"/>
//     </div>
// , document.getElementById('root'));
//
// ReactDOM.render(
//     <div>
//         <Saudacao tipo="Bom dia" nome="Daniel"/>
//     </div>
// , document.getElementById("root"));
ReactDOM.render(
    <div>
        {/*<Pai nome="Augusto" sobrenome="Pereira"/>*/}

        {/* Como passo os componentes filhos aqui?*/}
        <Pai nome="Paulo" sobrenome="Silva">
            <Filho nome="Pedro" sobrenome="Silva"/>
            <Filho nome="Paulo"/>
            <Filho/>
        </Pai>
    </div>
    , document.getElementById("root"));