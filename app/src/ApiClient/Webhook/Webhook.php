<?php
namespace ApiClient\Webhook;
use Exception;

class Webhook{
    private const LISTED_NUMBERS = [
       'Aline' => '554188829669',
    ];

    private const EXTRACTOR_MAP = [
        'onmessage' => OnMessageExtractor::class,
    ];
    

    private static function numberValidate($phoneNumber): bool{
        if(!in_array($phoneNumber, self::LISTED_NUMBERS)){
            return false;
        }
        return true;
    }

    private static function getExtractor($event){
        if (!isset(self::EXTRACTOR_MAP[$event])) {
            throw new Exception("Event not found: $event");
        }
        $extractorClass = self::EXTRACTOR_MAP[$event];
        return new $extractorClass();
    }

    private static function getTokens(){
        $config = parse_ini_file('../../../.env');
        return [
            'client' => $config['TOKENWPP'],
            'gemini' => $config['TOKENGEMINI']
        ];
    }

    public static function processaPayload($payload, $event){
        
        $extractor = self::getExtractor($event);
        $data = $extractor->extract($payload);

        if(empty($data)){
            throw new Exception("Empty data");
        }

        if(!self::numberValidate($data['phoneNumber'])){
            throw new Exception("Phone not found: $phoneNumber");
        }

        switch($event){
            case 'onmessage':
                $clientToken = self::getTokens()['client'];
                $geminiToken = self::getTokens()['gemini'];
                $agent = GeminiAgent::getInstance($geminiToken, $clientToken);
                $response = $agent->generateResponse($data);
                $agent->wait()->sendMessage($response);
                break;
        }
    }
        
        



}

