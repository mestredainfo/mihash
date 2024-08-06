<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

use MISistema\idioma\traduzir;
use MISistema\seguranca\post;
use MISistema\sistema\exec;
use MISistema\sistema\plataforma;
use MISistema\sistema\servidor;

$traduzir = new traduzir();
$plataforma = new plataforma();
$post = new post();
$servidor = new servidor();

$txtHash = '';

if ($post->solicitado()) {
    $sArquivo = $post->obter('arquivo');

    if (!empty($sArquivo)) {
        $sTipo = trim($post->obter('tipo'));
        $sHash = trim($post->obter('hash'));
        $sModo = $post->obter('modo');

        $exec = new exec();
        $exec->comando($sTipo . 'sum "' . $sArquivo . '"');
        $exec->consultar();

        while ($s = $exec->valores()) {
            $txtHash = strstr($s, ' ', true);
            $exec->limpar();
        }

        $exec->fechar();

        echo '<hr>' . $traduzir->obter('Hash do Arquivo:') . ' 
        <div class="mb-3">
        <input id="txtSalvarHash" type="text" value="' . $txtHash . '" class="form-control" readonly>
        </div>';

        if ($sModo == 'verificar') {
            if (!empty($sHash)) {
                if ($txtHash == $sHash) {
                    echo '<div class="alert alert-success"><strong>' . $traduzir->obter('O hash do arquivo é igual ao hash informado.') . '</strong></div>';
                } else {
                    echo '<div class="alert alert-danger"><strong>' . $traduzir->obter('Cuidado! O hash do arquivo não é igual ao hash informado.') . '<br>
                    &nbsp;' . $traduzir->obter('Não use esse arquivo por segurança!') . '</strong></div>';

                    echo '<div class="alert alert-info"><strong>' . $traduzir->obter('Recomendação:') . '<br>&nbsp;' . $traduzir->obter('Exclua e baixe o arquivo novamente, após baixar faça uma nova verificação de hash.') . '<br>
                    &nbsp;' . $traduzir->obter('Se o problema persistir entre em contato com o desenvolvedor do arquivo.') . '</strong></div>';
                }
            } else {
                echo '<div class="alert alert-warning">' . $traduzir->obter('Digite/Cole o hash do desenvolvedor para que seja possível realizar a verificação!') . '</div>';
            }
        } else {
            echo '<button id="btnSalvarArquivo" type="button" onclick="SalvarArquivo(\'' . $servidor->dominio() . '\')" class="btn btn-primary">' . $traduzir->obter('Salvar Hash') . '</button>';
        }
    } else {
        echo '<div class="alert alert-warning">' . $traduzir->obter('Selecione um arquivo para verificar') . '</div>';
    }
}
