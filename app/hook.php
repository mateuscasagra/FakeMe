<?php 
require __DIR__ . '/vendor/autoload.php';
use ApiClient\Client;
use ApiClient\Webhook\Webhook;



$jsonPayload = file_get_contents('php://input');

$payload = json_decode($jsonPayload);
$event = $payload['event'];
Webhook::processaPayload($payload, $event);








