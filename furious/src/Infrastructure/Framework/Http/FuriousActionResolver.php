<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Http;

use Framework\Http\ActionResolverInterface;
use Psr\Container\ContainerInterface;

final class FuriousActionResolver implements ActionResolverInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler): callable
    {
        return $this->container->get($handler);
    }
}
