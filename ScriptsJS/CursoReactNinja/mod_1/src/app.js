"use strict";

import React from 'react';
import Title from './title';

const App = React.createClass({
    render: function () {
        return (
            <div className="container">
                <Title name="Daniel"/>
            </div>
        );
    }
});

export default App;