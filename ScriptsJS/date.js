const date = new Date();

const dia = date.getDate();
let mes = String(date.getMonth() + 1);
mes = mes.length === 1 ? "0" + mes : mes;
const ano = date.getFullYear();
const formatedDate = dia + '/' + mes + '/' + ano + " às " + date.toLocaleTimeString();

console.log(formatedDate);
