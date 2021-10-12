<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\Entity\AcceptableInfrastructure;
use RegistruCentras\OneSign\Entity\Locale;
use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\Entity\SigningType;
use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\NamedPosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\AbsolutePosition;
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
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\CancelSigningResponseStatus;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\SigningResponseStatus;
use PHPUnit\Framework\TestCase;

final class IntegrationTest extends TestCase
{
    use WithTestClient;
    use WithTestSigner;
    use WithTestFile;
    use WithTestConfiguration;
    use WithTestTransaction;
    use WithTestSignatureConfiguration;
    
    protected Client $client;
    
    protected Client $clientWithoutPass;
    
    protected function setUp(): void
    {
        $this->client = self::setUpTestClient();
        $this->clientWithoutPass = self::setUpTestClientWithoutPass();
    }
    
    public function testInitWithMinimalInfo(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithClientWithoutPass(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->clientWithoutPass
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithTimestamp(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setSigningType(SigningType::SIGNATURE_WITH_TIMESTAMP)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithTimestampOcsp(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setSigningType(SigningType::SIGNATURE_WITH_TIMESTAMP_OCSP)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoMobileSigning(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setAcceptableInfrastructure(AcceptableInfrastructure::MOBILE)
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoStationarySigning(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setAcceptableInfrastructure(AcceptableInfrastructure::STATIONARY)
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithLtLocale(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setLocale(Locale::LT)
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithEnLocale(): string
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        
        $configuration = (new Configuration())
            ->setResponseUrl('http://aaaa')
            ->setLocale(Locale::EN)
            ->setSigningType(SigningType::SIGNATURE)
            ;
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoWithSigner(): string
    {
        $noSigner = self::setUpTestSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestEmptySignatureConfiguration();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
        
        return $response->getTransactionId();
    }
    
    public function testInitWithMinimalInfoAndMetadata(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithMetadata();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoAndHiddenPosition(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithHiddenPosition();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoAndRelativePositionInLeftAndTop(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithRelativePositionInLeftAndTop();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoAndRelativePositionInCenter(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithRelativePositionInCenter();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoRelativePositionAndSignatureAsImage(): void
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
            ->setSignatureImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
            ->setBackgroundImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
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
    
    public function testInitWithMinimalInfoRelativeAbsoluteAndSignatureAsImage(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        
        $absolutePosition = (new AbsolutePosition())
            ->setPage(1)
            ->setX('2cm')
            ->setY('-6cm')
            ->setWidth('8cm')
            ->setHeight('4cm')
            ->setDisplayValidity(true)
            ->setSignatureImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
            ->setBackgroundImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
            ;
        
        $signatureConfiguration = (new SignatureConfiguration())
            ->setDisplayProperties($absolutePosition)
            ;

        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoRelativeNamedAndSignatureAsImage(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        
         $namedPosition = (new NamedPosition())
            ->setFieldName('signature1')
            ->setDisplayValidity(true)
            ->setSignatureImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
            ->setBackgroundImageUrl('https://www.registrucentras.lt/img/logo/rc.jpg')
            ;
        
        $signatureConfiguration = (new SignatureConfiguration())
            ->setDisplayProperties($namedPosition)
            ;

        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoAndAbsolutePosition(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithAbsolutePosition();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testInitWithMinimalInfoAndNamedPosition(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $signatureConfiguration = self::setUpTestSignatureConfigurationWithNamedPosition();
        $configuration = self::setUpTestConfiguration();
        
        $response = $this->client
            ->init($noSigner, $testFile, $signatureConfiguration, $configuration)
            ;
            
        $this->assertIsString($response->getTransactionId());
        
        $this->assertIsString($response->getSigningUrl());
    }
    
    public function testSeal(): void
    {
        $response = $this->client
            ->seal(self::setUpTestFile())
            ;

        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    public function testTimestampWithoutSignerAndLocale(): void
    {
        $response = $this->client
            ->timestamp(self::setUpTestWithoutSigner(), self::setUpTestFile(), self::setUpTestEmptyConfiguration())
            ;
        
        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    public function testTimestampWithSigner(): void
    {
        $response = $this->client
            ->timestamp(self::setUpTestSigner(), self::setUpTestFile(), self::setUpTestEmptyConfiguration())
            ;
        
        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    public function testTimestampWithLtLocale(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $configuration = self::setUpTestConfigurationWithLocale(Locale::LT);
        
        $response = $this->client
            ->timestamp($noSigner, $testFile, $configuration)
            ;
        
        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    public function testTimestampWithEnLocale(): void
    {
        $noSigner = self::setUpTestWithoutSigner();
        $testFile = self::setUpTestFile();
        $configuration = self::setUpTestConfigurationWithLocale(Locale::EN);
        
        $response = $this->client
            ->timestamp($noSigner, $testFile, $configuration)
            ;
        
        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    public function testTimestampWithSignerAndLocale(): void
    {
        $noSigner = self::setUpTestSigner();
        $testFile = self::setUpTestFile();
        $configuration = self::setUpTestConfigurationWithLocale(Locale::LT);
        
        $response = $this->client
            ->timestamp($noSigner, $testFile, $configuration)
            ;
        
        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }
    
    /*public function testSignedResult(): void
    {
        $response = $this->client
            ->result(self::getSignedTransaction())
            ;

        $this->assertEquals($response->getStatus(), SigningResponseStatus::SIGNED);
    }*/
    
    /**
     * @depends testInitWithMinimalInfo
     */
    public function testResultBeforeCancel(string $transactionId): void
    {
        $response = $this->client
            ->result(self::setUpTestTransaction($transactionId))
            ;
            
        $this->assertEquals($response->getStatus(), SigningResponseStatus::IN_PROGRESS);
    }
    
    /**
     * @depends testInitWithMinimalInfo
     */
    public function testCancel(string $transactionId): void
    {
        $response = $this->client
            ->cancel(self::setUpTestTransaction($transactionId))
            ;
            
        $this->assertEquals($response->getStatus(), CancelSigningResponseStatus::CANCELED);
    }
    
    /**
     * @depends testInitWithMinimalInfo
     */
    public function testResultAfterCancel(string $transactionId): void
    {
        $response = $this->client
            ->result(self::setUpTestTransaction($transactionId))
            ;
            
        $this->assertEquals($response->getStatus(), SigningResponseStatus::CANCELED);
    }
}
