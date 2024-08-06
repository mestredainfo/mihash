<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

use MISistema\idioma\traduzir;
use MISistema\sistema\ambiente;
use MISistema\sistema\servidor;

$ambiente = new ambiente();
$traduzir = new traduzir();
$servidor = new servidor();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIHash</title>
    <link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="mb-3">
        <label for="txtTipoHash"><?php echo $traduzir->obter('Selecione o tipo de hash que deseja verificar'); ?></label>
        <select id="txtTipoHash" class="form-control">
            <option value="md5">MD5</option>
            <option value="sha1">SHA1</option>
            <option value="sha256">SHA256</option>
            <option value="sha512">SHA512</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="txtArquivo"><?php echo $traduzir->obter('Selecione o arquivo que deseja verificar o hash'); ?></label>
        <input id="txtArquivo" type="text" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label for="txtHash"><?php echo $traduzir->obter('Digite/Cole o hash informado pelo desenvolvedor'); ?></label>
        <input id="txtHash" type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label for="txtVerificar"><?php echo $traduzir->obter('Modo'); ?></label>
        <select id="txtVerificar" class="form-control">
            <option value="verificar"><?php echo $traduzir->obter('Verificar hash'); ?></option>
            <option value="gerar"><?php echo $traduzir->obter('Gerar apenas o hash do arquivo'); ?></option>
        </select>
    </div>

    <button type="button" class="btn btn-primary" onclick="checkHash('<?php echo $servidor->dominio(); ?>', event)"><?php echo $traduzir->obter('Verificar'); ?></button>

    <div id="resultado"></div>

    <div style="text-align:center;margin-top:17px">
        <strong>
            <?php echo $traduzir->obter('Veja como você pode apoiar este software,'); ?> <a href="javascript:misistema.abrirURL('https://www.mestredainfo.com.br/p/apoie.html');"><?php echo $traduzir->obter('clique aqui'); ?></a>
        </strong>
    </div>

    <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/hash.js"></script>
</body>

</html>
