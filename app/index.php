<?php 
require __DIR__ . '/vendor/autoload.php';
use ApiClient\Client;
$config = parse_ini_file('.env');
$client = new Client($config['TOKENWPP']);

$client->startSession('554184953092');
$client->sendMessage('554188829669', 'To quase chegando vida');
