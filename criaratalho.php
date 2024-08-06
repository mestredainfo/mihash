<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

use MISistema\app\config;
use MISistema\app\criaratalho;

$config = new config();
$criaratalho = new criaratalho();

$criaratalho->nome('MIHash')
    ->versao($config->obter('sistema', 'versao'))
    ->descricao('Verifica e gera hash de arquivos.')
    ->catUtilitarios()
    ->criar();
