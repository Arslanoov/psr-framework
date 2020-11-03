<?php

declare(strict_types=1);

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

require __DIR__ . '/../vendor/autoload.php';

define('ENV', 'dev');

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$responseBody = $psr17Factory->createStream('Furious 2.0');
$response = $psr17Factory->createResponse(200)
    ->withBody($responseBody);

if (ENV === 'dev') {
    $response = $response->withHeader('X-Developer', 'Arslanoov');
}

(new SapiEmitter())->emit($response);
