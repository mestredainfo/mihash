<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

use MISistema\app\arquivo;
use MISistema\idioma\traduzir;
use MISistema\seguranca\post;

$post = new post();
$traduzir = new traduzir();

if ($post->solicitado()) {
    $sArquivo = $post->obter('arquivo');
    $sFile = pathinfo($post->obter('file'));
    $sTipo = $post->obter('tipo');
    $sHash = $post->obter('hash');

    $arquivo = new arquivo();
    $arquivo->salvar(sprintf('%s.%s', $sArquivo, $sTipo), sprintf('%s %s', $sHash, $sFile['basename']));

    echo '<div class="alert alert-info">' . $traduzir->obter('Arquivo gerado com sucesso!') . '</div>';
}
