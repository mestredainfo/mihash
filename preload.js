// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

const { contextBridge, ipcRenderer } = require('electron')

ipcRenderer.setMaxListeners(20);

// Abrir, salvar e criar arquivo
contextBridge.exposeInMainWorld('arquivo', {
    Abrir: () => ipcRenderer.invoke('abrirArquivo'),
    Salvar: () => ipcRenderer.invoke('salvarArquivo'),
    criar: (filename, data) => ipcRenderer.invoke('createFile', filename, data)
});

// Abrir aplicativo externo
contextBridge.exposeInMainWorld('externo', {
    rodar: (url) => ipcRenderer.invoke('appExterno', url)
});

// Comando Terminal
let listenerAdded = false;
contextBridge.exposeInMainWorld('terminal', {
    comando: (tipo, arquivo) => ipcRenderer.invoke('runTerminal', tipo, arquivo),
    getDados: (listener) => {
        const eventHandler = (event, ...args) => listener(...args);

        if (!listenerAdded) {
            ipcRenderer.on('config:data', eventHandler);
            listenerAdded = true;
        }

        const removerOuvinte = () => {
            ipcRenderer.removeListener('config:data', eventHandler);
            listenerAdded = false;
        };

        return removerOuvinte;
    },
});

// Verifica nova versão para atualização
contextBridge.exposeInMainWorld('atualizacao', {
    verificar: () => ipcRenderer.invoke('verificaAtualizacao')
});
