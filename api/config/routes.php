<?php

declare(strict_types=1);

use App\Http\Action;
use App\Http\Middleware\Auth\Authenticate;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function(App $app) {
    $app->get('/', Action\HomeAction::class)->add(Authenticate::class);

    $app->map(['GET', 'POST'], '/authorize', Action\AuthorizeAction::class);
    $app->post('/token', Action\TokenAction::class);

    $app->group('/v1', function (RouteCollectorProxy $group): void {
        $group->group('/auth', function (RouteCollectorProxy $group): void {
            $group->post('/join', Action\V1\Auth\Join\RequestAction::class);
            $group->post('/join/confirm', Action\V1\Auth\Join\ConfirmAction::class);

            $group->get('/user', Action\V1\Auth\UserAction::class)->add(Authenticate::class);
        });
    });
};
