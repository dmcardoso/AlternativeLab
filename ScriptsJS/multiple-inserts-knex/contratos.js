const csvToJson = require('csvtojson');
const csvContratosPath = './arquivos_contratos/contratos.csv';
const csvAditivoValorPath = './arquivos_contratos/aditivo_valor.csv';
const csvAditivoPrazoPath = './arquivos_contratos//aditivo_prazo.csv';

const options = {delimiter: ';'};

const Knex = require('knex');
const knexfile = require('./knexfile');
const db = Knex(knexfile);

const start = async () => {

    // const licitacoes = await db('lic_licitacao');

    const contratos = await csvToJson(options).fromFile(csvContratosPath);

    const contratos_create = [];
    const contratados_create = [];
    await contratos.forEach((v, i) => {
        const new_contrato = {};
        new_contrato.tipo_id = 1;
        new_contrato.orgao_id = 1;
        new_contrato.numero_contrato = v['NUMERO'];
        new_contrato.ano = v['DATAPUBLICACAO'].split('/')[2];
        new_contrato.descricao = v['OBJETO'];
        new_contrato.valor_total = parseFloat(v['VALOR'].replace('.', '').replace(',', '.'));
        new_contrato.inicio_vigencia = v['DATAINICIO'].split('/').reverse().join('-');
        new_contrato.final_vigencia = v['DATAFINAL'].split('/').reverse().join('-');
        new_contrato.data_publicacao = v['DATAPUBLICACAO'].split('/').reverse().join('-');
        new_contrato.fiscal_contrato = ''; // Não precisa mudar

        contratos_create.push(new_contrato);
    });

    const trxProvider = db.transactionProvider();

    const trx = await trxProvider();


    const begin = async (call) => {
        try {
            const insert = async () => {
                contratos_create.forEach(async (v, i) => {
                    return await trx.insert(v).into('cnt_contrato')
                        .then(res => {
                            console.log(res);
                            contratos_create[i].id = res[0];
                            return i;
                        })
                        .catch(e => {
                            console.log(e);
                        })
                        .then(res => call && (res + 1) === contratos_create.length ? call(contratos_create) : null);

                });


            };

            await insert();
        } catch (e) {
            throw new Error(e);
        } finally {
            console.log('destruiu');
            db.destroy().catch(err => console.log('Não foi possível encerrar conexão', err));
        }
    };

    begin(function (param) {
        console.log('param retornado das queries', param,trxProvider);
    }).catch(e => console.log(e));
};

start();