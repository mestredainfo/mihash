<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

header("Content-Security-Policy: default-src 'self'");
header("Content-Security-Policy: script-src 'self' 'unsafe-inline' script.js");

if (empty($_GET['c'])) {
    include_once(dirname(__FILE__) . '/checkupdate.php');
    checkupdate();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIHash</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="form-control">
        <label for="txtTipoHash">Selecione o tipo de hash que deseja verificar</label>
        <select id="txtTipoHash">
            <option value="md5">MD5</option>
            <option value="sha1">SHA1</option>
            <option value="sha256">SHA256</option>
            <option value="sha512">SHA512</option>
        </select>
    </div>
    <div class="form-control">
        <label for="txtArquivo">Selecione o arquivo que deseja verificar o hash</label>
        <input id="txtArquivo" type="text" readonly>
    </div>
    <div class="form-control">
        <label for="txtHash">Digite/Cole o hash informado pelo desenvolvedor</label>
        <input id="txtHash" type="text">
    </div>
    <div class="form-control">
        <label for="txtVerificar">Modo</label>
        <select id="txtVerificar">
            <option value="verificar">Verificar hash</option>
            <option value="gerar">Gerar apenas o hash do arquivo</option>
        </select>
    </div>

    <button type="button" class="btn btn-primary" onclick="checkHash(event)">Verificar</button>

    <div id="resultado"></div>

    <div style="text-align:center;margin-top:17px">
        <strong>
            Veja como você pode apoiar este software, <a href="javascript:window.externo.rodar('https://mestredainfo.wordpress.com/apoie/');">clique aqui</a>
        </strong>
    </div>

    <script src="/js/script.js"></script>
    <script src="/js/hash.js"></script>
</body>

</html>