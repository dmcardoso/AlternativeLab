const gulp = require('gulp');
const util = require('gulp-util');
const sequence = require('run-sequence');

// Importa os outros arquivos
require ('./gulptasks/app');
require ('./gulptasks/deps');
require ('./gulptasks/servidor');

gulp.task('default', () => {
    // Flag para ser usada com -production
    if(util.env.production){
        // Sequence executa as tasks em sequência e só funciona se as tasks tiverem return
        sequence('deps', 'app');
        // Padrão do gulp
        // gulp.start('deps', 'app');
    }else{
        sequence('deps', 'app', 'servidor');
        // gulp.start('deps', 'app', 'servidor');
    }
});