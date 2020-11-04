<?php

declare(strict_types=1);

namespace Framework\Http;

interface ActionResolverInterface
{
    /**
     * @param mixed $handler
     * @return callable
     */
    public function resolve($handler): callable;
}
