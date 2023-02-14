<?php

declare(strict_types=1);

namespace App\Modules\Subscriber\Action;

use App\Modules\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomeAction implements RequestHandlerInterface
{
    /**
     * @throws \JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(new \stdClass());
    }
}