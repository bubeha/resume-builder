<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class BaseAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write('Hello world!');

        return $response;
    }
}
