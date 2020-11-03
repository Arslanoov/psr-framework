<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Http;

use Framework\Http\ApplicationInterface;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Application implements ApplicationInterface
{
    private RouterInterface $router;

    /**
     * Application constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function get(string $name, string $path, string $handler, array $options = []): void
    {
        $this->addRoute($name, $path, $handler, ['GET'], $options);
    }

    public function post(string $name, string $path, string $handler, array $options = []): void
    {
        $this->addRoute($name, $path, $handler, ['POST'], $options);
    }

    public function patch(string $name, string $path, string $handler, array $options = []): void
    {
        $this->addRoute($name, $path, $handler, ['PATCH'], $options);
    }

    public function put(string $name, string $path, string $handler, array $options = []): void
    {
        $this->addRoute($name, $path, $handler, ['PUT'], $options);
    }

    public function delete(string $name, string $path, string $handler, array $options = []): void
    {
        $this->addRoute($name, $path, $handler, ['DELETE'], $options);
    }

    public function customMethodsRoute(
        string $name,
        string $path,
        string $handler,
        array $methods,
        array $options = []
    ): void {
        $this->addRoute($name, $path, $handler, $methods, $options);
    }

    private function addRoute(string $name, string $path, string $handler, array $methods, array $options = []): void
    {
        $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Add psr15 package
    }
}
