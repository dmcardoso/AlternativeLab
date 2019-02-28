'use strict';

import React from 'react';

const Title = ({name, lastname}) => (
    <div>Olá {name + " " + lastname}!</div>
);

Title.defaultProps = {
    name: "Desconhecido",
    lastname: "Sem sobrenome"
};

export default Title;