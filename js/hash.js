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
    txtArquivo.value = await window.miapp.openFile()
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

    window.miapp.translate('Verificando hash...').then((result) => {
        document.getElementById('resultado').innerHTML = '<div class="alert alert-info">' + result + '</div>';
    });

    await post('/controls/checkhash.php', formData, function (response) {
        document.getElementById('resultado').innerHTML = response;
    });

    e.preventDefault();
}

// Salvar Arquivo
async function SalvarArquivo() {
    var txtArquivo = await window.miapp.saveFile()
    if (txtArquivo) {
        let formData = new FormData();
        formData.append("arquivo", txtArquivo);
        formData.append("file", document.getElementById('txtArquivo').value);
        formData.append("tipo", document.getElementById('txtTipoHash').value);
        formData.append("hash", document.getElementById('txtSalvarHash').value);

        window.miapp.translate('Salvando hash...').then((result) => {
            document.getElementById('resultado').innerHTML = '<div class="alert alert-info">' + result + '</div>';
        });
       

        await post('/controls/savehash.php', formData, function (response) {
            document.getElementById('resultado').innerHTML = response;
        });
    }
}