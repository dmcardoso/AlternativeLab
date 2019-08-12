const initialState = {
    activeLesson: {},
    activeModule: {},
    modules: [
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
    ],
};

export default function course (state = initialState, action) {
    if (action.type === 'SET_LESSON_ACTIVE') {
        return {
            ...state,
            activeLesson: action.lesson,
            activeModule: action.module
        };
    }

    return state;
}