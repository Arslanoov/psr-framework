<?php

declare(strict_types=1);

use Aura\Router\RouterContainer;
use Framework\Http\ApplicationInterface;
use Infrastructure\Framework\Http\Application;
use Infrastructure\Framework\Http\Router\AuraRouterAdapter;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

chdir(dirname(__DIR__));
define('ENV', 'dev');

require './vendor/autoload.php';

$container = require './config/container.php';

$application = $container->get(ApplicationInterface::class);

(require './config/app/routes/index.php')($application);
(require './config/app/pipeline/index.php')($application);

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$response = $application->run($serverRequest);

if (ENV === 'dev') {
    $response = $response->withHeader('X-Developer', 'Arslanoov');
}

(new SapiEmitter())->emit($response);
