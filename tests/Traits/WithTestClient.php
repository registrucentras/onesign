<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Client;

trait WithTestClient
{
    public static function setUpTestClient(): Client
    {

        $client = new Client();

        $client->configure(
            \getenv('ONESIGN_ENPOINT'),
            \getenv('ONESIGN_TEST_USER'),
            \str_replace('||', "\n", \getenv('ONESIGN_PRIVATE_KEY')),
            \getenv('ONESIGN_PRIVATE_KEY_PASSPHRASE'),
            \str_replace('||', "\n", \getenv('ONESIGN_PUBLIC_KEY'))
        );

        return $client;
    }

    public static function setUpTestClientWithoutPass(): Client
    {

        $client = new Client();

        $client->configure(
            \getenv('ONESIGN_ENPOINT'),
            \getenv('ONESIGN_TEST_USER_WITHOUT_PASS'),
            \str_replace('||', "\n", \getenv('ONESIGN_PRIVATE_KEY_WITHOUT_PASS')),
            '',
            \str_replace('||', "\n", \getenv('ONESIGN_PUBLIC_KEY'))
        );

        return $client;
    }
}
