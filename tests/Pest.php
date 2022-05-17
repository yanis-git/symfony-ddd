<?php

use App\Kernel;
use Psr\Container\ContainerInterface;

function app(): Kernel
{
    static $kernel;
    $kernel ??= (function () {
        $env = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'test';
        $debug = $_ENV['APP_DEBUG'] ?? $_SERVER['APP_DEBUG'] ?? true;

        $kernel = new Kernel((string) $env, (bool) $debug);
        $kernel->boot();

        return $kernel;
    })();

    return $kernel;
}

/**
 * Shortcut to the test container (all services are public).
 */
function container(): ContainerInterface
{
    $container = app()->getContainer();

    return $container->has('test.service_container') ? $container->get('test.service_container') : $container;
}
