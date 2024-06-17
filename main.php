<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo
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
    <div class="mb-3">
        <label for="txtTipoHash"><?php echo miTranslate('Selecione o tipo de hash que deseja verificar'); ?></label>
        <select id="txtTipoHash" class="form-control">
            <option value="md5">MD5</option>
            <option value="sha1">SHA1</option>
            <option value="sha256">SHA256</option>
            <option value="sha512">SHA512</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="txtArquivo"><?php echo miTranslate('Selecione o arquivo que deseja verificar o hash'); ?></label>
        <input id="txtArquivo" type="text" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label for="txtHash"><?php echo miTranslate('Digite/Cole o hash informado pelo desenvolvedor'); ?></label>
        <input id="txtHash" type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label for="txtVerificar"><?php echo miTranslate('Modo'); ?></label>
        <select id="txtVerificar" class="form-control">
            <option value="verificar"><?php echo miTranslate('Verificar hash'); ?></option>
            <option value="gerar"><?php echo miTranslate('Gerar apenas o hash do arquivo'); ?></option>
        </select>
    </div>

    <button type="button" class="btn btn-primary" onclick="checkHash(event)"><?php echo miTranslate('Verificar'); ?></button>

    <div id="resultado"></div>

    <div style="text-align:center;margin-top:17px">
        <strong>
            <?php echo miTranslate('Veja como você pode apoiar este software,'); ?> <a href="javascript:window.externo.rodar('https://www.mestredainfo.com.br/assinantes/');"><?php echo miTranslate('clique aqui'); ?></a>
        </strong>
    </div>

    <script src="/js/script.js"></script>
    <script src="/js/hash.js"></script>
</body>

</html>
