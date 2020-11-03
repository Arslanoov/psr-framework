<?php

declare(strict_types=1);

use Aura\Router\RouterContainer;
use Infrastructure\Framework\Http\Application;
use Infrastructure\Framework\Http\Router\AuraRouterAdapter;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

chdir(dirname(__DIR__));
define('ENV', 'dev');

require './vendor/autoload.php';

require __DIR__ . './config/routes.php';

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

// TODO: Add DI
$response = (new Application(new AuraRouterAdapter(new RouterContainer())))->run($serverRequest);

if (ENV === 'dev') {
    $response = $response->withHeader('X-Developer', 'Arslanoov');
}

(new SapiEmitter())->emit($response);
