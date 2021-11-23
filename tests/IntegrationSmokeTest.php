<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\Entity\Locale;
use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition\RelativeX;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition\RelativeY;
use RegistruCentras\OneSign\Exception\SoapErrorException;
use RegistruCentras\OneSign\Tests\Traits\WithTestClient;
use RegistruCentras\OneSign\Tests\Traits\WithTestSigner;
use RegistruCentras\OneSign\Tests\Traits\WithTestFile;
use RegistruCentras\OneSign\Tests\Traits\WithTestConfiguration;
use RegistruCentras\OneSign\Tests\Traits\WithTestTransaction;
use RegistruCentras\OneSign\Tests\Traits\WithTestSignatureConfiguration;
use PHPUnit\Framework\TestCase;

final class IntegrationSmokeTest extends TestCase
{
    use WithTestClient;
    use WithTestSigner;
    use WithTestFile;
    use WithTestConfiguration;
    use WithTestTransaction;
    use WithTestSignatureConfiguration;

    protected Client $client;

    protected function setUp(): void
    {
        $this->client = self::setUpTestClient();
    }

    public function testResultWithNotExistsTransactionId(): void
    {
        $this->expectException(SoapErrorException::class);
        $this->expectExceptionMessage('Invalid transaction ID.');

        $response = $this->client
            ->result(self::setUpTestRandomTransaction())
            ;
    }

    public function testCancelWithNotExistsTransactionId(): void
    {
        $this->expectException(SoapErrorException::class);
        $this->expectExceptionMessage('Invalid transaction ID.');

        $response = $this->client
            ->cancel(self::setUpTestRandomTransaction())
            ;
    }

    public function testInitWithMinimalInfoRelativePositionAndSignatureAsNotExistsImage(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();

        $relativePosition = (new RelativePosition())
            ->setPage(1)
            ->setX(RelativeX::CENTER)
            ->setY(RelativeY::CENTER)
            ->setWidth('8cm')
            ->setHeight('4cm')
            ->setDisplayValidity(true)
            ->setSignatureImageUrl('https://www.registrucentras.lt/img/logo/rcrc.jpg')
            ->setBackgroundImageUrl('https://www.registrucentras.lt/img/logo/rcrc.jpg')
            ;

        $signatureConfiguration = (new SignatureConfiguration())
            ->setDisplayProperties($relativePosition)
            ;

        $configuration = self::setUpTestConfiguration();

        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;

        $this->assertIsString($response->getTransactionId());

        $this->assertIsString($response->getSigningUrl());
    }
}
