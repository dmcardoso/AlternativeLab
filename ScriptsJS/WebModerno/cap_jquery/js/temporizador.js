(function ($) {
    $.fn.temporizador = function (opcoes) {
        const opcoesFinais = $.extend({
            message: "Em breve!",
            schedule: "23:59:59"
        }, opcoes);

        const horaDezena = $('<span class="digito">').html(0),
            horaUnidade = $('<span class="digito">').html(0),
            minutoDezena = $('<span class="digito">').html(0),
            minutoUnidade = $('<span class="digito">').html(0),
            segundoDezena = $('<span class="digito">').html(0),
            segundoUnidade = $('<span class="digito">').html(0),
            separadorHora = $('<span class="separador">').html(':'),
            separadorMinuto = $('<span class="separador">').html(':'),
            mensagem = $('<div class="mensagem" >').html(opcoesFinais.message);

        this.addClass('temporizador');
        $(this).append(horaDezena, horaUnidade, separadorHora, minutoDezena, minutoUnidade, separadorMinuto, segundoDezena, segundoUnidade, mensagem);

        const regex = new RegExp(/(\d\d):(\d\d):(\d\d)/);
        const horarioAlvo = regex.exec(opcoesFinais.schedule);

        let temporizador = setInterval(() => {
            const agora = new Date();
            const alvo = new Date();
            alvo.setHours(horarioAlvo[1]);
            alvo.setMinutes(horarioAlvo[1]);
            alvo.setSeconds(horarioAlvo[3]);

            const diferencaEmMili = alvo.getTime() - agora.getTime();

            if(diferencaEmMili >= 0){
                const diferenca = regex.exec(new Date(diferencaEmMili).toISOString());

                horaDezena.html(diferenca[1][0]);
                horaUnidade.html(diferenca[1][1]);
                minutoDezena.html(diferenca[2][0]);
                minutoUnidade.html(diferenca[2][1]);
                segundoDezena.html(diferenca[3][0]);
                segundoUnidade.html(diferenca[3][1]);
            }else{
                clearInterval(temporizador);
            }
        },1000);


        return this;
    }
})(jQuery);