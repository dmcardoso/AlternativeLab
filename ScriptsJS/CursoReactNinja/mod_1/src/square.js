'use strict';

import React from 'react';

const Square = ({color}) =>
    <div style={{
        background: color,
        height: '100px',
        width: '100px'
    }}/>;

Square.defaulProps = {
    color: 'red'
};

export default Square;