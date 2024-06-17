<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

if (miRequestPost()) {
    $sArquivo = miCleanPost('arquivo');
    $sFile = pathinfo(miCleanPost('file'));
    $sTipo = miCleanPost('tipo');
    $sHash = miCleanPost('hash');

    file_put_contents(sprintf('%s.%s', $sArquivo, $sTipo), sprintf('%s %s', $sHash, $sFile['basename']));

    echo '<div class="alert alert-info">' . miTranslate('Arquivo gerado com sucesso!') . '</div>';
}
