module.exports = values => {

    const react_component = values => {
        return `
            import React from 'react';
    
            const ${values.name} = props =>
    
            export default ${values.name};
        `;
    };

    this.somar = (valores) => {
        return valores * valores;
    };

    // return {react_component, somar};

};