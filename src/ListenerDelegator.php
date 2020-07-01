<?php

namespace Mbiya135\Mezzio\Sentry;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Mbiya135\Mezzio\Sentry\Listener\Listener;

class ListenerDelegator implements DelegatorFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $listener = $container->get(Listener::class);
        $errorHandler = $callback();
        if ($listener->config()['enable'] === true) {
            $errorHandler->attachListener($listener);
        }

        return $errorHandler;
    }
}