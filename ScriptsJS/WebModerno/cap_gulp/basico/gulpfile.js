const gulp = require('gulp');

// Task padrão. Portal de entrada
gulp.task('default', () => {
    gulp.start('copiar', 'fim');
});

// Pré requisitos dentro do array no segundo parâmetro
gulp.task('copiar', ['antes1', 'antes2'], () => {
    gulp.src(['pastaA/arquivo1.txt', 'pastaA/arquivo2.txt'])
    // Apenas um parâmetro
    // gulp.src('pastaA/arquivo1.txt')
    // Qualquer arquivo com aquela extensão
    // gulp.src('pastaA/*.txt')
    // Qualquer arquivo com aquela extensão naquela pasta e subniveis dela
    // gulp.src('pastaA/**/*.txt')
    // Encadear chamadas de funções
    // .pipe(transformacao1())
    // .pipe(transformacao2())
        .pipe(gulp.dest('pastaB'));
});

// Função pré requisito
gulp.task('antes1', () => {
    console.log("Antes 1");
});

// Função pré requisito
gulp.task('antes2', () => {
    console.log("Antes 2");
});

// Task que chama outras duas sem função
gulp.task('fim', ['fim1', 'fim2']);

// Função pré requisito
gulp.task('fim1', () => {
    console.log("Fim 1");
});
// Função pré requisito
gulp.task('fim2', () => {
    console.log("Fim 2");
});
