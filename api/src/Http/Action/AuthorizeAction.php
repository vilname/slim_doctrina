<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Http\Response\HtmlResponse;
use App\Modules\Auth\Query\FindIdByCredentials\Fetcher;
use App\Modules\Auth\Query\FindIdByCredentials\Query;
use App\Modules\OAuth\Entity\User;
use Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;

class AuthorizeAction implements RequestHandlerInterface
{
    private AuthorizationServer $server;
    private LoggerInterface $logger;
    private Environment $template;
    private ResponseFactoryInterface $response;
    private Fetcher $users;

    public function __construct(
        AuthorizationServer $server,
        LoggerInterface $logger,
        Fetcher $users,
        Environment $template,
        ResponseFactoryInterface $response,
    ) {
        $this->server = $server;
        $this->logger = $logger;
        $this->users = $users;
        $this->template = $template;
        $this->response = $response;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $authRequest = $this->server->validateAuthorizationRequest($request);

            $query = new Query();

            if ($request->getMethod() === 'POST') {
                $body = $request->getParsedBody();

                $query->email = $body['email'] ?? '';
                $query->password = $body['password'] ?? '';

                $user = $this->users->fetch($query);

                if ($user === null) {
                    $error = 'Incorrect email or password.';

                    return new HtmlResponse(
                        $this->template->render('authorize.html.twig', compact('query', 'error')),
                        400
                    );
                }

                if (!$user->isActive) {
                    $error = 'User is not confirmed.';

                    return new HtmlResponse(
                        $this->template->render('authorize.html.twig', compact('query', 'error')),
                        409
                    );
                }

                $authRequest->setUser(new User($user->id));
                $authRequest->setAuthorizationApproved(true);

                return $this->server->completeAuthorizationRequest($authRequest, $this->response->createResponse());
            }

            return new HtmlResponse(
                $this->template->render('authorize.html.twig', compact('query'))
            );
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), ['exception' => $exception]);
            return $exception->generateHttpResponse($this->response->createResponse());
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            return (new OAuthServerException('Server error.', 0, 'unknown_error', 500))
                ->generateHttpResponse($this->response->createResponse());
        }
    }
}
