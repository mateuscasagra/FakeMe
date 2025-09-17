<?php
namespace ApiClient\Webhook;
use Exception;

class Webhook{
    // private const LISTED_IPS = [
    //    'Helena' => '18.215.79.89',
    //    'Mateus' => '172.18.0.6'
    // ];

    // private const EXTRACTOR_MAP = [
    //     'CONTACT_NEW' => ContactNewExtractor::class,
    //     'CONTACT_UPDATE' => ContactUpdateExtractor::class,
    // ];
    

    private static function validaIp($ipRequest): bool{
        if(!in_array($ipRequest, self::LISTED_IPS)){
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

    public static function processaPayload($payload, $ipRequest){
        // if(!self::validaIp($ipRequest)){
        //     throw new Exception("Ip not found: $ipRequest");
        // }

        // $extractor = self::getExtractor($event);
        // $data = $extractor->extract($payload);

        // if(empty($data)){
        //     throw new Exception("Empty data");
        // }

        file_put_contents('hook.txt', $payload);
        
        switch($event){
            case 'CONTACT_NEW':
                $contato = new LogicaContato(new MapperContato($data['companyId']));
                $contato->criaContato($data);
                break;
        }
        

    }


}

