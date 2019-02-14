<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 14/02/2019
 * Time: 09:35
 */
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/styles.css" type="text/css">
    <title>Conversor de e-mails para importação</title>
</head>
<body>

<article>
    <h1>Importador de e-mails</h1>
    <p>
        Para realizar a importação dos e-mails basta entrar na hospedagem do site a ser migrado, entrar na pasta
        <strong>.cpanel</strong>
        e baixar ou clicar para editar o arquivo <strong>email_accounts.json</strong>, copiar seu conteúdo e colar no
        campo de texto ao lado.
    </p>
    <p>
        Caso a pasta .cpanel não esteja visível basta ir ao botão de configurações e marcar a opção <strong>Mostrar
            arquivos ocultos (dotfiles)</strong>, como na imagem:
        <img src="./assets/imgs/emailscpanel.png" alt="Cpanel">
    </p>
    <p>Para a importação o índice <strong>"__version"</strong> deve ser apagado, ele pode estar tanto no início quanto
        no final do documento.(
        <i>Caso haja outros índices, os mesmos também devem ser excluídos, deixando apenas o índice referente ao domínio
            portador dos e-mails.</i>)</p>
    <p>Estrutura do json: </p>

    <pre>
        {
            "exemplo.go.gov.br": {
                "shadow_mtime": 1550142360,
                "account_count": 87,
                "accounts": {
                    "sms": {
                        "diskused": "619251477",
                        "disk_mtime": 1529001076,
                        "diskquota": "1073741824",
                        "suspended_login": 0
                    },
                    "almoxarifado": {
                        "suspended_login": 0,
                        "diskquota": "1073741824",
                        "disk_mtime": 1528387534,
                        "diskused": "0"
                    }
                }
            }
        }
        </pre>
    <p><i>*O índice <strong>shadow_mtime</strong> não é obrigatório.</i></p>
</article>
<form action="converter.php" method="post">
    <h1>Campos de importação</h1>
    <p>Caso a senha não seja preenchida será criado um padrão: prefixo_do_dominio@prefixo_do_email, Ex.:
        exemplo.go.gov.br -> exemplo@juridico</p>
    <label for="senha">Digite a senha: (opcional / 6 dígitos)</label>
    <input type="text" name="senha" id="senha">

    <label for="json">JSON:</label>
    <textarea name="json" id="json"></textarea>
    <button type="submit">ENVIAR</button>
    <p><i>*Após o download do CSV é necessário entrar no cpanel da hospedagem que receberá os e-mails e clicar em
            importador de endereços e selecionar o arquivo gerado. (Nenhuma configuração adicional é necessária)*</i>
    </p>
</form>

</body>
</html>
