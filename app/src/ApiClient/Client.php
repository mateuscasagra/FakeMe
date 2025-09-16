<?php

namespace ApiClient;

class Client{
    private HttpClient $client;

    public function __construct($token){
        $this->client = new HttpClient($token);
    }

    public function getToken(){
        return $this->client->doRequest('POST', 'generate-token');
    }

    public function startSession($phoneNumber){
        $dados = [
            'phone' => $phoneNumber
        ];
        return $this->client->doRequest('POST', 'start-session', $dados);
    }

    public function sendMessage($phoneNumber, $message){
        $dados = [
            'phone' => $phoneNumber,
            'message' => $message
        ];
        return $this->client->doRequest('POST', 'send-message', $dados);
    }
}