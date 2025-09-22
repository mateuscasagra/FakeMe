<?php 
require __DIR__ . '/vendor/autoload.php';
require 'constants.php';
use ApiClient\Client;
use ApiClient\Webhook\Webhook;
use Agent\GeminiAgent;

$jsonPayload = file_get_contents('php://input');
$payload = json_decode($jsonPayload);
$event = $payload->event;
Webhook::processaPayload($payload, $event);
// file_put_contents('status.txt', $jsonPayload);












