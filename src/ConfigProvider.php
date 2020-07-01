<?php

namespace Mbiya135\Mezzio\Sentry;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mbiya135\Mezzio\Sentry\Listener\Listener;
use Mbiya135\Mezzio\Sentry\Listener\ListenerFactory;

class ConfigProvider
{
    /**
     * @return array|array[]
     */
    public function __invoke(): array
    {
        return ['dependencies' => $this->getDependencies(),];
    }

    /**
     * @return array
     */
    private function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories' => [
                Listener::class => ListenerFactory::class,
            ],
            'delegators' => [
                ErrorHandler::class => [
                    ListenerDelegator::class,
                ],
            ],
        ];
    }
}