const valor_compra = 483.12;

const total_parcelas = 6;

const desconto_ao_ano = 5.07;

const parcelas_com_desconto = 4;

const calculaDescontoAoMes = (desconto) => desconto / 12;

const porcentagem = (valor) => valor / 100;

const calculaDescontoTotal = (valor_parcela, valor_desconto) => valor_parcela - (valor_parcela * porcentagem(valor_desconto));

const valorParcelas = (valor, parcelas) => valor / parcelas;

const totalParcelaComDesconto = (valor_compra, total_parcelas, desconto_ao_ano, fixed = 4) => calculaDescontoTotal(valorParcelas(valor_compra, total_parcelas), calculaDescontoAoMes(desconto_ao_ano)).toFixed(fixed);

const calculaDesconto = (valor_compra, total_parcelas, parcelas_com_desconto, desconto_ao_ano, fixed = 4) => {
    const valor_parcelas = valorParcelas(valor_compra, total_parcelas);
    const novo_valor_compra = (valor_compra / total_parcelas) * parcelas_com_desconto;

    const desconto_por_mes = calculaDescontoAoMes(desconto_ao_ano);

    let novo_valor_total = 0;

    const novas_parcelas = [];

    for (let i = 0; i < parcelas_com_desconto; i++) {
        let novo_valor = 0;

        if (novas_parcelas.length === 0) {
            novo_valor = calculaDescontoTotal(valor_parcelas, desconto_por_mes);
        } else {
            novo_valor = calculaDescontoTotal(novas_parcelas[i - 1], desconto_por_mes);
        }

        novas_parcelas[i] = novo_valor;
        novo_valor_total += novo_valor;
    }

    const diferenca = (novo_valor_compra - novo_valor_total).toFixed(fixed);

    const diferenca_do_total = valor_compra - diferenca;

    return {
        valor_anterior: novo_valor_compra,
        novo_valor: Number(novo_valor_total.toFixed(fixed)),
        parcelas: novas_parcelas,
        diferenca,
        diferenca_do_total
    };
};

console.log(totalParcelaComDesconto(valor_compra, total_parcelas, desconto_ao_ano));

console.log(calculaDesconto(valor_compra, total_parcelas, parcelas_com_desconto, desconto_ao_ano));