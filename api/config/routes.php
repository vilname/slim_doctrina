<?php

declare(strict_types=1);

use App\Http;
use Slim\App;

return static function(App $app) {
    $app->get('/', Http\Action\HomeAction::class);
};
