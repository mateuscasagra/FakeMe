<?php 
require __DIR__ . '/vendor/autoload.php';
require 'constants.php';
use ApiClient\Client;
use ApiClient\Webhook\Webhook;



$jsonPayload = file_get_contents('php://input');
$payload = json_decode($jsonPayload);
$event = $payload->event;
Webhook::processaPayload($payload, $event);


// $config = parse_ini_file(ENV);
// $client = new Client($config['TOKENWPP']);
// file_put_contents('status.txt', $client->statusSession());
// $client->startSession('554184953092');






