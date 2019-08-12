const stringToRender = (data) =>{
  return `Meu nome é ${data.nome} e eu tenho ${data.anos}.
     Curso as seguintes matérias: ${data.materias.map(materia => ` ${materia}`)}
  `;
};


const render = (string, data) =>{
    console.log(string(data));
};

render(stringToRender, {nome: "Daniel", anos: 19, materias: ['Inglês', "Matemática", "Português"]});