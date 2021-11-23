<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\HttpClient\Builder;
use Http\Mock\Client as MockClient;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class MockedClient
{
    public static function create(ResponseInterface $response): Client
    {
        $client = new MockClient(self::createResponseFactory($response));

        return new Client(new Builder($client));
    }

    private static function createResponseFactory(ResponseInterface $response): ResponseFactoryInterface
    {
        return new class ($response) implements ResponseFactoryInterface {
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
            {
                return $this->response;
            }
        };
    }
}
