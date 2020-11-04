<?php

declare(strict_types=1);

use App\Http\Response\ResponseFactory;
use Infrastructure\Application\Http\NyholmResponseFactory;
use Psr\Container\ContainerInterface;

return [
    ResponseFactory::class => static function (ContainerInterface $container): ResponseFactory {
        return $container->get(NyholmResponseFactory::class);
    }
];
