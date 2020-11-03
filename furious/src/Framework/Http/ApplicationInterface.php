<?php

declare(strict_types=1);

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ApplicationInterface
{
    public function run(ServerRequestInterface $request): ResponseInterface;
}
