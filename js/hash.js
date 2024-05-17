// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

/**
 * @requires miapp
 */

// Abrir arquivo
const txtArquivo = document.getElementById('txtArquivo');

txtArquivo.addEventListener('click', async () => {
    txtArquivo.value = await window.arquivo.abrir()
    if (txtArquivo.value == 'undefined') {
        txtArquivo.value = '';
    }
});

async function checkHash(e) {
    let formData = new FormData();
    formData.append("arquivo", txtArquivo.value);
    formData.append("tipo", document.getElementById('txtTipoHash').value);
    formData.append("hash", document.getElementById('txtHash').value);
    formData.append("modo", document.getElementById('txtVerificar').value);

    document.getElementById('resultado').innerHTML = '<div class="alert alert-info">Verificando hash...</div>';

    await post('checkhash.php', formData, function (response) {
        document.getElementById('resultado').innerHTML = response;
    });

    e.preventDefault();
}

// Salvar Arquivo
async function SalvarArquivo() {
    var txtArquivo = await window.arquivo.salvar()
    if (txtArquivo) {
        let formData = new FormData();
        formData.append("arquivo", txtArquivo);
        formData.append("file", document.getElementById('txtArquivo').value);
        formData.append("tipo", document.getElementById('txtTipoHash').value);
        formData.append("hash", document.getElementById('txtSalvarHash').value);

        document.getElementById('resultado').innerHTML = '<div class="alert alert-info">Salvando hash...</div>';

        await post('savehash.php', formData, function (response) {
            document.getElementById('resultado').innerHTML = response;
        });
    }
}