<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

$txtHash = '';

if (miRequestPOST()) {
    $sArquivo = miCleanPOST('arquivo');

    if (!empty($sArquivo)) {
        $sTipo = trim(miCleanPost('tipo'));
        $sHash = trim(miCleanPost('hash'));
        $sModo = miCleanPost('modo');

        if (miIsLinux()) {
            $cmd = $sTipo . 'sum "' . $sArquivo . '"';
        } else {
            $cmd = '"certUtil" "-hashfile" "' . addcslashes($sArquivo, '\\"') . '" ' . strtoupper($sTipo);
        }

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        flush();

        if (miIsLinux()) {
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
        } else {
            $process = proc_open($cmd, $descriptorspec, $pipes, null, null);
        }

        if (is_resource($process)) {
            while ($s = fgets($pipes[1])) {
                if (miIsLinux()) {
                    $txtHash = strstr($s, ' ', true);
                } else {
                    $txtHash .= str_replace(' ', '', $s) . ' ';
                }

                flush();
            }
        }

        proc_close($process);

        if (!miIsLinux()) {
            $a = explode(' ', $txtHash);
            $txtHash = trim($a[1]);
        }

        echo '<br><hr>' . miTranslate('Hash do Arquivo:') . ' 
        <div class="mb-3">
        <input id="txtSalvarHash" type="text" value="' . $txtHash . '" class="form-control" readonly>
        </div>';

        if ($sModo == 'verificar') {
            if (!empty($sHash)) {
                if ($txtHash == $sHash) {
                    echo '<div class="alert alert-success"><strong>' . miTranslate('O hash do arquivo é igual ao hash informado.') . '</strong></div>';
                } else {
                    echo '<div class="alert alert-danger"><strong>' . miTranslate('Cuidado! O hash do arquivo não é igual ao hash informado.') . '<br>
                    &nbsp;' . miTranslate('Não use esse arquivo por segurança!') . '</strong></div>';
                    
                    echo '<div class="alert alert-info"><strong>' . miTranslate('Recomendação:') . '<br>&nbsp;' . miTranslate('Exclua e baixe o arquivo novamente, após baixar faça uma nova verificação de hash.') . '<br>
                    &nbsp;' . miTranslate('Se o problema persistir entre em contato com o desenvolvedor do arquivo.') . '</strong></div>';
                }
            } else {
                echo '<div class="alert alert-warning">' . miTranslate('Digite/Cole o hash do desenvolvedor para que seja possível realizar a verificação!') . '</div>';
            }
        } else {
            echo '<button id="btnSalvarArquivo" type="button" onclick="SalvarArquivo()" class="btn btn-primary">' . miTranslate('Salvar Hash') . '</button>';
        }
    } else {
        echo '<div class="alert alert-warning">' . miTranslate('Selecione um arquivo para verificar') . '</div>';
    }
}
