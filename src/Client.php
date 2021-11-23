<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign;

use RegistruCentras\OneSign\Api\Init;
use RegistruCentras\OneSign\Api\Result;
use RegistruCentras\OneSign\Api\Cancel;
use RegistruCentras\OneSign\Api\Timestamp;
use RegistruCentras\OneSign\Api\Seal;
use RegistruCentras\OneSign\Entity\Signer;
use RegistruCentras\OneSign\Entity\File;
use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\Entity\Transaction;
use RegistruCentras\OneSign\HttpClient\Builder;
use RegistruCentras\OneSign\HttpClient\Plugin\ExceptionThrower;
use RegistruCentras\OneSign\HttpClient\Plugin\SoapRequest;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter\InitRequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter\ResultRequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter\CancelRequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter\TimestampRequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter\SealRequestAdapter;
use Http\Client\Common\HttpMethodsClientInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private Builder $httpClientBuilder;

    private string $clientId;

    private string $privateKey;

    private string $passphrase;

    private string $publicKey;

    private string $apiEndpointUrl = '';

    public function __construct(Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new ExceptionThrower());
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    public function init(
        Signer $signer,
        File $file,
        SignatureConfiguration $signatureConfiguration,
        Configuration $configuration
    ): ResponseDTOInterface {
        $this->httpClientBuilder->addPlugin(new SoapRequest('InitSigning'));

        $initRequestAdapter = new InitRequestAdapter($this, $signer, $file, $signatureConfiguration, $configuration);

        return (new Init($this))($initRequestAdapter);
    }

    public function result(Transaction $transaction): ResponseDTOInterface
    {
        $this->httpClientBuilder->addPlugin(new SoapRequest('SigningResult'));

        $resultRequestAdapter = new ResultRequestAdapter($this, $transaction);

        return (new Result($this))($resultRequestAdapter);
    }

    public function cancel(Transaction $transaction): ResponseDTOInterface
    {
        $this->httpClientBuilder->addPlugin(new SoapRequest('SigningCancel'));

        $resultRequestAdapter = new CancelRequestAdapter($this, $transaction);

        return (new Cancel($this))($resultRequestAdapter);
    }

    public function timestamp(Signer $signer, File $file, Configuration $configuration): ResponseDTOInterface
    {
        $this->httpClientBuilder->addPlugin(new SoapRequest('Timestamp'));

        $timestampRequestAdapter = new TimestampRequestAdapter($this, $signer, $file, $configuration);

        return (new Timestamp($this))($timestampRequestAdapter);
    }

    public function seal(File $file): ResponseDTOInterface
    {
        $this->httpClientBuilder->addPlugin(new SoapRequest('Seal'));

        $sealRequestAdapter = new SealRequestAdapter($this, $file);

        return (new Seal($this))($sealRequestAdapter);
    }

    public function configure(
        string $apiEndpointUrl,
        string $clientId,
        string $privateKey,
        string $passphrase,
        string $publicKey
    ): void {
        $this->apiEndpointUrl = $apiEndpointUrl;
        $this->clientId = $clientId;
        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
        $this->publicKey = $publicKey;
    }

    public function getApiEndpointUrl(): string
    {
        return $this->apiEndpointUrl;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }


    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPassphrase(): string
    {
        return $this->passphrase;
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    public function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
