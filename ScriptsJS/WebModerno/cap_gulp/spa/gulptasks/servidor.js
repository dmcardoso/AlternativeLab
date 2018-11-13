const gulp = require('gulp');
const watch = require('gulp-watch');
const webserver = require('gulp-webserver');

gulp.task('monitorarMudancas', () => {
    // Assiste os arquivos para ver se tem mudanças para executar uma task
    watch('src/**/*.html', () => gulp.start('app.html'));
    watch('src/**/*.scss', () => gulp.start('app.css'));
    watch('src/**/*.js', () => gulp.start('app.js'));
    watch('src/assets/imgs/**/*.*', () => gulp.start('app.imgs'));
});

gulp.task('servidor', ['monitorarMudancas'], () => {
    // Servidor web
    return gulp.src('build').pipe(webserver({
        // Atualiza
        livereload: true,
        // Porta
        port: 3003,
        // Abre na tela
        open: true
    }));
});