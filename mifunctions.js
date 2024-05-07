// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Organização: Mestre da Info
// Site: https://linktr.ee/mestreinfo

const { ipcMain, dialog } = require('electron')

module.exports = {
    mifunctions: function (win) {
        // Função para abrir arquivo
        ipcMain.handle('abrirArquivo', async () => {
            const { canceled, filePaths } = await dialog.showOpenDialog({});
            if (!canceled) {
                return filePaths[0];
            }
        });

        // Função para salvar arquivo
        ipcMain.handle('salvarArquivo', async () => {
            const { canceled, filePath } = await dialog.showSaveDialog({});
            if (!canceled) {
                return filePath;
            }
        });

        // Abrir aplicativo externo
        ipcMain.handle('appExterno', async (event, url) => {
            require('electron').shell.openExternal(url);
        });

        // Comando Terminal
        ipcMain.handle('runTerminal', async (event, tipo, arquivo) => {
            var childProcess = require('child_process');
            const child = childProcess.exec(tipo + 'sum "' + arquivo + '"');

            child.stdout.on('data', (d) => {
                win.webContents.send('config:data', d); // Send the data to the render thread
            });

            child.stdout.on('close', () => {
                child.unref();
                child.kill();
            });
        });

        // Gerar arquivo
        ipcMain.handle('createFile', async (event, filename, data) => {
            const fs = require('fs')

            fs.writeFile(filename, data, (err) => {
                if (err) {
                    console.error('Ocorreu um erro:', err);
                } else {
                    console.log('Arquivo gerado com sucesso!');
                }
            })
        });

        // Verifica nova versão para atualização
        ipcMain.handle('verificaAtualizacao', async () => {
            checkUpdate(true);
        });

        // Função para verificar novas versões do software
        async function checkUpdate(a) {
            try {
                const axios = require('axios');
                const cheerio = require('cheerio');

                // URL da página HTML que você deseja analisar
                const url = 'https://mestredainfo.wordpress.com/mihash/';

                const versaoatual = require('electron').app.getVersion();

                // Realiza a requisição HTTP
                const response = await axios.get(url);

                // Carrega o HTML retornado usando a biblioteca cheerio
                const $ = cheerio.load(response.data);

                // Extrai os dados desejados
                const versaonova = $('#appversion').text();

                if (versaonova > versaoatual) {
                    const options = {
                        type: 'question',
                        buttons: ['Mais tarde', 'Atualizar Agora'],
                        title: 'Deseja baixar a nova versão?',
                        message: 'A versão ' + versaonova + ' já está disponível.'
                    };

                    require('electron').dialog.showMessageBox(null, options).then(retorno => {
                        if (retorno.response === 1) {
                            require('electron').shell.openExternal(url);
                        }
                    });
                } else {
                    if (a) {
                        const options = {
                            type: "info",
                            buttons: ['Continuar'],
                            title: 'Verificação de Atualização',
                            message: 'O software já está na versão mais recente.'
                        };
    
                        require('electron').dialog.showMessageBox(null, options); 
                    }
                }
            } catch (error) {
                console.error('Erro ao buscar os dados:', error);
            }
        }

        checkUpdate(false);
    }
}