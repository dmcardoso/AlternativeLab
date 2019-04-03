export function toggleLesson (module, lesson) {
    return {
        type: 'SET_LESSON_ACTIVE',
        module,
        lesson
    };
}