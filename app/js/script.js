// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

// Abrir arquivo
const txtArquivo = document.getElementById('txtArquivo');

txtArquivo.addEventListener('click', async () => {
    txtArquivo.value = await window.arquivo.Abrir()
});

async function checkHash(e) {
    var sTipoHash = document.getElementById('txtTipoHash').value;

    document.getElementById('resultado').innerHTML = '<div class="alert alert-info">Verificando hash...</div>';

    window.terminal.comando(sTipoHash, txtArquivo.value);

    window.terminal.getDados((jsonData) => {
        var sHash = document.getElementById('txtHash').value;
        var sHashFile = jsonData.split(' ');
        var sModo = document.getElementById('txtVerificar').value;

        document.getElementById('hash').innerHTML = sHashFile[0];

        if (sModo == 'verificar') {
            if (sHashFile[0] == sHash) {
                document.getElementById('resultado').innerHTML = '<div class="alert alert-success">São iguais!</div>';
            } else {
                document.getElementById('resultado').innerHTML = '<div class="alert alert-danger">São diferentes!</div>';
            }
        } else {
            SalvarArquivo();
        }
    });

    e.preventDefault();
}

// Salvar Arquivo
async function SalvarArquivo() {
    var txtSalvarArquivo = await window.arquivo.Salvar()

    document.getElementById('resultado').innerHTML = '<div class="alert alert-info">Salvando hash...</div>';

    await window.arquivo.criar(txtSalvarArquivo, document.getElementById('hash').innerHTML);

    document.getElementById('resultado').innerHTML = '<div class="alert alert-info">Hash salvo com sucesso!</div>';
}

function abrirExterno(url) {
    window.externo.rodar(url);
}

function novaVersao() {
    window.atualizacao.verificar();
}