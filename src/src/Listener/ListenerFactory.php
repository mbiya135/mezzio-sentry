<?php

namespace Mbiya135\Mezzio\Sentry\Listener;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Mbiya135\Mezzio\Sentry\Listener\Listener;

class ListenerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        return new Listener($config);
    }
}