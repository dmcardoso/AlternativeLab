const gulp = require('gulp');

// Concatena vários arquivos em um só
const concat = require('gulp-concat');

// Retira os espaços em branco para deixar o arquivo o mais compactado possível
// Deixa o código 'bagunçado'
const uglify = require('gulp-uglify');

// Precisa do babel-core e babel-preset-env
// Preset env determina automaticamente quais versões você deve utilizar para compulação do código
// Babel faz tradução de uma língua pra outra como typescript para js
const babel = require('gulp-babel');

gulp.task('default', () => {
    // Pega todos os arquivos incluindo no src que tem a extensão .js
    return gulp.src('src/**/*.js')
        .pipe(
            babel(
                {
                    // Se não quiser usar o uglify
                    // minified: true,
                    comments: false,
                    presets: ['env']
                }
            )
        )
        .pipe(
            // Executa a uglify
            uglify()
        ).on('error', (err) => console.log(err))
        .pipe(concat('codigo.min.js'))
        .pipe(gulp.dest('build'));
});