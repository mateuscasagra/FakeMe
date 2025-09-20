<?php 
namespace ApiClient\Webhook\Extractors;

class OnMessageExtractor  { //implements Extractor

    public function extract($data){
        $messageText = $data->body;
        $numberFrom  = $data->from;
        $phoneNumber = $this->phoneFormat($numberFrom);

        return [
            'messageText' => $messageText,
            'phoneNumber' => $phoneNumber
        ];
    }

    public function phoneFormat($phoneNumber){
        $phoneSplited = explode('@', $phoneNumber);
        $phoneFormatted = $phoneSplited[0];
        return $phoneFormatted;
    }
}