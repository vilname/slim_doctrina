<?php

declare(strict_types=1);

use App\Modules\OAuth\Entity\AccessTokenRepository;
use App\Modules\OAuth\Entity\AuthCode;
use App\Modules\OAuth\Entity\AuthCodeRepository;
use App\Modules\OAuth\Entity\Client;
use App\Modules\OAuth\Entity\ClientRepository;
use App\Modules\OAuth\Entity\RefreshToken;
use App\Modules\OAuth\Entity\RefreshTokenRepository;
use App\Modules\OAuth\Entity\Scope;
use App\Modules\OAuth\Entity\ScopeRepository;
use App\Modules\OAuth\Entity\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Psr\Container\ContainerInterface;

return [
    ScopeRepositoryInterface::class => static function (ContainerInterface $container): ScopeRepository {
        $config = $container->get('config')['oauth'];

        return new ScopeRepository(
            array_map(static fn (string $item): Scope => new Scope($item), $config['scopes'])
        );
    },
    ClientRepositoryInterface::class => static function (ContainerInterface $container): ClientRepository {
        $config = $container->get('config')['oauth'];

        return new ClientRepository(
            array_map(static function (array $item): Client {
                return new Client(
                    $item['client_id'],
                    $item['name'],
                    $item['redirect_uri']
                );
            }, $config['clients'])
        );
    },
    UserRepositoryInterface::class => DI\get(UserRepository::class),
    AccessTokenRepositoryInterface::class => DI\get(AccessTokenRepository::class),
    AuthCodeRepositoryInterface::class => static function (ContainerInterface $container): AuthCodeRepository {
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(AuthCode::class);
        return new AuthCodeRepository($em, $repo);
    },
    RefreshTokenRepositoryInterface::class => static function (ContainerInterface $container): RefreshTokenRepository {
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(RefreshToken::class);
        return new RefreshTokenRepository($em, $repo);
    },

    'config' => [
        'oauth' => [
            'scopes' => [
                'common',
            ],
            'clients' => [
                [
                    'name' => 'Auction',
                    'client_id' => 'frontend',
                    'redirect_uri' => getenv('FRONTEND_URL') . '/oauth',
                ],
            ],
        ],
    ],
];
