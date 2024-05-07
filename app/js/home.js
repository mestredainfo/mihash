// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

var sHTML = document.body;
sHTML.innerHTML = `
    <a href="index.html?p=sobre" target="_blank" rel="noopener" class="btn btn-primary">Sobre o MiHash</a> <a href="javascript:novaVersao();" class="btn btn-primary">Verificar Atualização</a>
    <hr>
    <div class="form-control">
        <label for="txtTipoHash">Selecione o tipo de hash que deseja verificar</label>
        <select id="txtTipoHash">
            <option value="md5">MD5</option>
            <option value="sha1">SHA1</option>
            <option value="sha256">SHA256</option>
            <option value="sha512">SHA512</option>
        </select>
    </div>
    <div class="form-control">
        <label for="txtArquivo">Selecione o arquivo que deseja verificar o hash</label>
        <input id="txtArquivo" type="text" readonly>
    </div>
    <div class="form-control">
        <label for="txtHash">Digite/Cole o hash informado pelo desenvolvedor</label>
        <input id="txtHash" type="text">
    </div>
    <div class="form-control">
        <label for="txtVerificar">Modo</label>
        <select id="txtVerificar">
            <option value="verificar">Verificar hash</option>
            <option value="gerar">Gerar apenas o hash do arquivo</option>
        </select>
    </div>

    <button type="button" class="btn btn-primary" onclick="checkHash(event)">Verificar</button>

    <div id="hash"></div>
    <div id="resultado"></div>`;

var scriptJS = document.createElement('script');
scriptJS.src = '../js/script.js';
document.body.appendChild(scriptJS);