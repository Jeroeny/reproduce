<?php

use Symfony\Component\HttpClient\HttpClient;

require __DIR__ . '/vendor/autoload.php';

$client = new \Symfony\Component\HttpClient\Psr18Client(
    HttpClient::create(),
    new Http\Factory\Guzzle\ResponseFactory(),
    new Http\Factory\Guzzle\StreamFactory(),
);

$response = $client->sendRequest(new \GuzzleHttp\Psr7\Request(
    'GET',
    'https://raw.githubusercontent.com/symfony/symfony/master/.gitignore',
));

echo $response->getBody();