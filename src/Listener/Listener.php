<?php

namespace Mbiya135\Mezzio\Sentry\Listener;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\State\Scope;
use Throwable;

class Listener
{

    /** @var array */
    private array $config;

    /**
     * Listener constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $client = ClientBuilder::create($this->config['sentry'])->getClient();
        SentrySdk::init()->bindClient($client);
    }

    /**
     * @param Throwable $error
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function __invoke(
        Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): void {
        SentrySdk::getCurrentHub()->withScope(
            function (Scope $scope) use ($error) {
                $scope->setExtra('file', $error->getFile());
                $scope->setExtra('line', $error->getLine());
                $scope->setExtra('code', $error->getCode());

                SentrySdk::getCurrentHub()->captureException($error);
            }
        );
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return $this->config;
    }
}
