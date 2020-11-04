<?php

declare(strict_types=1);

namespace Framework\Http\Pipeline\Middleware;

use Framework\Http\Pipeline\MiddlewareResolverInterface;
use Framework\Http\Router\Result;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DispatchMiddleware implements MiddlewareInterface
{
    private MiddlewareResolverInterface $middlewareResolver;
    private ContainerInterface $container;

    /**
     * DispatchMiddleware constructor.
     * @param MiddlewareResolverInterface $middlewareResolver
     * @param ContainerInterface $container
     */
    public function __construct(MiddlewareResolverInterface $middlewareResolver, ContainerInterface $container)
    {
        $this->middlewareResolver = $middlewareResolver;
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Result $result */
        if (!$result = $request->getAttribute(Result::class)) {
            return $handler->handle($request);
        }
        $middleware = $this->middlewareResolver->resolve($result->getHandler());
        return $middleware->process($request, $handler);
    }
}
