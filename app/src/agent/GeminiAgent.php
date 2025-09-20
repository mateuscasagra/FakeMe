<?php

namespace Agent;
use Gemini;
use ApiClient\Client;

class GeminiAgent{
    private static $instance;
    private $agent;
    private $client;

    private function __construct($apiKeyGemini, $apiKeyClient){
        $this->agent = Gemini::factory()
        ->withApiKey($apiKeyGemini)
        ->make();
        $this->client = new Client($apiKeyClient);
    }

    public function wait(){
        $listWaitTime = [
            '10',
            '15',
            '30',
            '60'
        ];
        $randomWaitTime = $listWaitTime[random_array($listWaitTime)];
        sleep($randomWaitTime * 60);
        return $this;
    }

    public static function getInstance($apiKeyGemini, $apiKeyClient){
        if(self::$instance == null){
            self::$instance = new self($apiKeyGemini, $apiKeyClient);
        }

        return self::$instance;
    } 

    public function generateResponse($messageText){
        $prompt = include_once("promptFe.php");
        $finalPrompt = str_replace('[COLE A NOVA MENSAGEM DELA AQUI]', $messageText, $prompt);
        $result = $this->agent->generativeModel('gemini-1.5-flash')->generateContent($finalPrompt);
        return $result->text();
    }

    public function sendMessage($iaMessage, $phoneNumber){
        $this->client->sendMessage('554185337004', $phoneNumber);
    }

}









