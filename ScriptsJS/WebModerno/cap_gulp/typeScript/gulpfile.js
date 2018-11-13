const gulp = require('gulp');

const ts = require('gulp-typescript');
// Carrega o arquivo de configuração
const tsProject = ts.createProject('tsconfig.json');

gulp.task('default', () => {
    return tsProject.src()
    // Compila o ts para js
        .pipe(tsProject())
        .pipe(gulp.dest('build'));
});