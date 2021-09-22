<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests;

use RegistruCentras\OneSign\Client;
use Http\Client\Common\HttpMethodsClientInterface;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }
}
