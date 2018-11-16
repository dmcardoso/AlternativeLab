import React from 'react';
// import Filho from './Filho';
import {childrenWithProps} from "../uteis/util";

export default props =>
    <div>
        <h1>{props.nome} {props.sobrenome}</h1>
        <h2>Filhos</h2>
        <ul>
            {/*<Filho nome="Pedro" sobrenome={props.sobrenome}/>*/}
            {/*<Filho {...props}/>*/}
            {/*<Filho {...props} nome="Carla"/>*/}

            {/*{props.children}*/}
            {
                childrenWithProps(props)
            }

        </ul>
    </div>