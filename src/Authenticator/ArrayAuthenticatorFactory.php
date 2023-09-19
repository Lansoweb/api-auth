<?php

declare(strict_types=1);

namespace Los\ApiAuth\Authenticator;

use Psr\Container\ContainerInterface;

use function assert;
use function is_array;

class ArrayAuthenticatorFactory
{
    public function __invoke(ContainerInterface $container): ArrayAuthenticator
    {
        $config = $container->get('config');
        assert(is_array($config));

        /** @var string[]|array<string, string> $identities */
        $identities = $config['los']['api-auth']['identities'] ?? $config['api-auth']['identities'] ?? [];

        return new ArrayAuthenticator($identities);
    }
}
