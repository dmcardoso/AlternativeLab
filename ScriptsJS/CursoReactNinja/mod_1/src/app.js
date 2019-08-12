"use strict";

import React, {Component} from 'react';
// import Title from './title';
import Square from './square';

class App extends Component {
    render() {
        return (
            <div className="container">
                {/*<Title name="Daniel"/>*/}
                {['blue', 'red', 'green', 'yellow'].map((color, index) => (
                    <Square color={color} key={index}/>
                ))}
                {/*<Square color="blue"/>*/}
            </div>
        );
    }
}

export default App;