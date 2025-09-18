<?php
namespace ApiClient\Webhook;
use Exception;

class Webhook{
    private const LISTED_NUMBERS = [
       'Aline' => '554188829669',
    ];

    private const EXTRACTOR_MAP = [
        'ON_MESSAGE' => OnMessageExtractor::class,
    ];
    

    private static function numberValidate($phoneNumber): bool{
        if(!in_array($phoneNumber, self::LISTED_NUMBERS)){
            return false;
        }
        return true;
    }

    private static function getExtractor($event)
    {
        if (!isset(self::EXTRACTOR_MAP[$event])) {
            throw new Exception("Event not found: $event");
        }
        $extractorClass = self::EXTRACTOR_MAP[$event];
        return new $extractorClass();
    }

    public static function processaPayload($payload, $phoneNumber){
        if(!self::numberValidate($phoneNumber)){
            throw new Exception("Phone not found: $phoneNumber");
        }

        $extractor = self::getExtractor($event);
        $data = $extractor->extract($payload);

        if(empty($data)){
            throw new Exception("Empty data");
        }
        
        switch($event){
            case 'onmessage':
                $response = new ResponseMessage();
                $response->sendMessage($data);
                break;
        }
        

    }


}

