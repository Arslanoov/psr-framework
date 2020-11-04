<?php

declare(strict_types=1);

namespace Framework\Http\Pipeline;

interface MiddlewareResolverInterface
{
    /**
     * @param $handler
     * @return mixed
     */
    public function resolve($handler);
}
