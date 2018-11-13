const gulp = require('gulp');
const sass = require('gulp-sass');
const uglifycss = require('gulp-uglifycss');
const concat = require('gulp-concat');

// Função pré requisito copiar html
gulp.task('default', ['copiarHtml'], () => {
    // Pega o arquivo que tem todos os imports
    gulp.src('src/sass/index.scss')
    //Vê se tem erro no sass
        .pipe(sass().on('error', sass.logError))
        // Aplica o uglify com comentrários
        .pipe(uglifycss({"uglyComments": true}))
        // Renomeia o arquivo
        .pipe(concat('estilo.min.css'))
        // Move para a pasta correta
        .pipe(gulp.dest('build/css'));
});

// Função pré requisito
gulp.task('copiarHtml', () => {
    gulp.src('src/index.html')
        .pipe(gulp.dest('build'));
});