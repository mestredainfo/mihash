<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

$txtHash = '';
$sServer = filter_var($_SERVER['REQUEST_METHOD'], FILTER_DEFAULT, FILTER_NULL_ON_FAILURE);
if ($sServer == 'POST') {
    $sArquivo = filter_input(INPUT_POST, 'arquivo');

    if (!empty($sArquivo)) {
        $sTipo = trim(filter_input(INPUT_POST, 'tipo'));
        $sHash = trim(filter_input(INPUT_POST, 'hash'));
        $sModo = filter_input(INPUT_POST, 'modo');

        if (PHP_OS == 'Linux') {
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

        if (PHP_OS == 'Linux') {
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
        } else {
            $process = proc_open($cmd, $descriptorspec, $pipes, null, null);
        }

        if (is_resource($process)) {
            while ($s = fgets($pipes[1])) {
                if (PHP_OS == 'Linux') {
                    $txtHash = strstr($s, ' ', true);
                } else {
                    $txtHash .= str_replace(' ', '', $s) . ' ';
                }

                flush();
            }
        }

        proc_close($process);

        if (PHP_OS !== 'Linux') {
            $a = explode(' ', $txtHash);
            $txtHash = trim($a[1]);
        }

        echo '<br><hr>Hash do Arquivo: 
        <div class="form-control">
        <input id="txtSalvarHash" type="text" value="' . $txtHash . '" readonly>
        </div>';

        if ($sModo == 'verificar') {
            if (!empty($sHash)) {
                if ($txtHash == $sHash) {
                    echo '<div class="alert alert-success">São iguais!</div>';
                } else {
                    echo '<div class="alert alert-danger">São diferentes!</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Digite/Cole o hash do desenvolvedor para que seja possível realizar a verificação!</div>';
            }
        } else {
            echo '<button id="btnSalvarArquivo" type="button" onclick="SalvarArquivo()" class="btn btn-primary">Salvar Hash</button>';
        }
    } else {
        echo '<div class="alert alert-warning">Selecione um arquivo para verificar</div>';
    }
}
