<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Api;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\HttpClient\Message\RequestMediator;
use RegistruCentras\OneSign\HttpClient\Util\Signatory;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApi
{
    public string $endpoint;
    
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->setEndpoint($client->getApiEndpointUrl());
    }

    protected function getClient(): Client
    {
        return $this->client;
    }
    
    protected function makeHttpRequest(string $url, RequestDTOInterface $requestDTO): ResponseInterface
    {
        $request = $this->client->getHttpClientBuilder()->getRequestFactory()->createRequest('POST', $url);
        
        $privateKey = $this->client->getPrivateKey();
        
        $passphrase = $this->client->getPassphrase();

        $signature = Signatory::sign((string)$requestDTO, $privateKey, $passphrase);
        
        $body = RequestMediator::generateRequestRawBody($requestDTO->withBased64Signature($signature));
        
        $request = $request->withBody($this->client->getHttpClientBuilder()->getStreamFactory()->createStream($body));
        
        return $this->client->getHttpClient()->sendRequest($request);
    }
    
    protected function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}
