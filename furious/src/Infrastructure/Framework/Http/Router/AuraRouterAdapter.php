<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Http\Router;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Exception\RequestNotMatched;
use Framework\Http\Router\Exception\UnableToFoundRoute;
use Framework\Http\Router\Result;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\RouterInterface;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuraRouterAdapter
 * @package Infrastructure\Framework\Router
 * @author ElisDN https://github.com/ElisDN
 */
final class AuraRouterAdapter implements RouterInterface
{
    private RouterContainer $aura;

    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();
        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RequestNotMatched($request);
    }

    public function generate(string $name, array $params): string
    {
        $generator = $this->aura->getGenerator();
        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new UnableToFoundRoute($name, $params);
        }
    }

    public function addRoute(RouteData $data): void
    {
        $route = new Route();
        $route->name($data->name);
        $route->path($data->path);
        $route->handler($data->handler);

        foreach ($data->options as $name => $value) {
            switch ($name) {
                case 'tokens':
                    $route->tokens($value);
                    break;
                case 'defaults':
                    $route->defaults($value);
                    break;
                case 'wildcard':
                    $route->wildcard($value);
                    break;
                default:
                    throw new InvalidArgumentException('Undefined option "' . $name . '"');
            }
        }

        if ($methods = $data->methods) {
            $route->allows($methods);
        }

        $this->aura->getMap()->addRoute($route);
    }
}
