// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

/**
 * @requires misistema
 */

// Abrir arquivo
const txtArquivo = document.getElementById('txtArquivo');

txtArquivo.addEventListener('click', async () => {
    txtArquivo.value = await misistema.abrirArquivo()
    if (txtArquivo.value == 'undefined') {
        txtArquivo.value = '';
    }
});

async function checkHash(dominio, e) {
    let formData = {
        arquivo: txtArquivo.value,
        tipo: document.getElementById('txtTipoHash').value,
        hash: document.getElementById('txtHash').value,
        modo: document.getElementById('txtVerificar').value
    }

    misistema.traduzir('Verificando hash...').then((result) => {
        document.getElementById('resultado').innerHTML = '<div class="alert alert-info">' + result + '</div>';
    });

    misistema.post(dominio + '/controls/checkhash.php', formData);
    misistema.listPost((response) => {
        document.getElementById('resultado').innerHTML = response;
    });

    e.preventDefault();
}

// Salvar Arquivo
async function SalvarArquivo(dominio) {
    var txtArquivo = await misistema.salvarArquivo()
    if (txtArquivo) {
        let formData = {
        arquivo: txtArquivo,
        file: document.getElementById('txtArquivo').value,
        tipo: document.getElementById('txtTipoHash').value,
        hash: document.getElementById('txtSalvarHash').value
    }

        misistema.traduzir('Salvando hash...').then((result) => {
            document.getElementById('resultado').innerHTML = '<div class="alert alert-info">' + result + '</div>';
        });

        misistema.post(dominio + '/controls/savehash.php', formData);
        misistema.listPost((response) => {
            document.getElementById('resultado').innerHTML = response;
        });
    }
}