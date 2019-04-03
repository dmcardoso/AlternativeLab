import { createStore } from 'redux';

function reducer () {
    return [
        {
            id: 1,
            title: 'Iniciando com React',
            lessons: [
                {
                    id: 1,
                    title: 'Primeira aula',
                },
                {
                    id: 2,
                    title: 'Segunda aula',
                },
            ],
        },
        {
            id: 2,
            title: 'Iniciando com Redux',
            lessons: [
                {
                    id: 3,
                    title: 'Primeira aula',
                },
                {
                    id: 4,
                    title: 'Segunda aula',
                },
            ],
        },
    ];
}

const store = createStore(reducer);

export default store;