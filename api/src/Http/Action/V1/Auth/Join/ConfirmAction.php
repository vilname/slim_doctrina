<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Auth\Join;

use App\Http\Response\EmptyResponse;
use App\Http\Validator\Validator;
use App\Modules\Auth\Command\JoinByEmail\Confirm\Command;
use App\Modules\Auth\Command\JoinByEmail\Confirm\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ConfirmAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $command = new Command();
        $command->token = $data['token'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(200);
    }
}
