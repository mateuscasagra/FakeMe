<?php 
require __DIR__ . '/vendor/autoload.php';
use ApiClient\Client;
use ApiClient\Webhook\Webhook;
$config = parse_ini_file('.env');
$client = new Client($config['TOKENWPP']);


$jsonPayload = file_get_contents('php://input');

$payload = json_decode($jsonPayload);

file_put_contents("text.txt", $jsonPayload);







