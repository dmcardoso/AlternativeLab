'use strict';

import React from 'react';

const Title = React.createClass({
    getDefaultProps: function () {
        return {
            name: "Desconhecido",
            lastname: "Sem sobrenome"
        };
    },
    render: function () {
        return (<div>Olá {this.props.name + " " + this.props.lastname}!</div>)
    }
});

export default Title;