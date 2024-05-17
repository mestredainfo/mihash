<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

header("Content-Security-Policy: default-src 'self'");
header("Content-Security-Policy: script-src 'self' 'unsafe-inline' script.js");

$sServer = filter_var($_SERVER['REQUEST_METHOD'], FILTER_DEFAULT, FILTER_NULL_ON_FAILURE);
if ($sServer == 'POST') {
    $sArquivo = filter_input(INPUT_POST, 'arquivo');
    $sFile = pathinfo(filter_input(INPUT_POST, 'file'));
    $sTipo = filter_input(INPUT_POST, 'tipo');
    $sHash = filter_input(INPUT_POST, 'hash');

    file_put_contents(sprintf('%s.%s', $sArquivo, $sTipo), sprintf('%s %s', $sHash, $sFile['basename']));

    echo '<div class="alert alert-info">Arquivo gerado com sucesso!</div>';
}
