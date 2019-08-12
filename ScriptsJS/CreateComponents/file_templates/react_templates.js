const react_component = values => {
    return `
import React from 'react';
import './${values.name}.${values.typeStyle}';
    
const ${values.name} = props =>
    <div>Componente ${values.name}</div>
    
export default ${values.name};
        `;
};

const react_class_component = values => {
    return `
import React, {Component} from 'react';
import './${values.name}.${values.typeStyle}';

class ${values.name} extends Component{

    render(){
        return(
            <div>Componente ${values.name}</div>
        );
    }
}

export default ${values.name};
  `;
};

module.exports = {react_component, react_class_component};