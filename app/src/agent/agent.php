<?php

// Inclui o autoload do Composer para carregar as bibliotecas
require __DIR__ . '/../../vendor/autoload.php';

// Importa a classe principal do Factory
use Gemini;

// Carrega as configurações do arquivo .env
$config = parse_ini_file(__DIR__ . '/../../.env');
$apiKey = $config['TOKENGEMINI'];

$novaMensagemDela = "A gente não devia ter marcado com ninguém sábado ksksk";

$megaPrompt = include_once("prompt.php");

// --- EXECUÇÃO ---

try {
    // 1. Substitui o placeholder no prompt pela nova mensagem real
    $promptFinal = str_replace('[COLE A NOVA MENSAGEM DELA AQUI]', $novaMensagemDela, $megaPrompt);

    // 2. Usa o "builder" (factory) padrão para criar o cliente da API
    $client = Gemini::factory()
        ->withApiKey($apiKey)
        ->make();

    // 3. Envia o prompt final para o modelo
    echo "Agente pensando...\n\n";

    // CORREÇÃO FINAL E DEFINITIVA:
    // Usa o método genérico `generativeModel()` e passa o nome do modelo como uma string.
    $result = $client->generativeModel('gemini-1.5-flash')->generateContent($promptFinal);

    // 4. Salva a resposta gerada pela IA
    $resultMsg = "Namorada: " . $novaMensagemDela . "\n" . "Mateus (IA): " . $result->text();
    file_put_contents('outputAgent.txt', $resultMsg);

    echo "Resposta salva em outputAgent.txt";

} catch (\Exception $e) {
    // Captura e exibe qualquer erro que possa ocorrer durante a chamada da API
    echo "Ocorreu um erro ao chamar a API: " . $e->getMessage();
}