<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response;

use RegistruCentras\OneSign\HttpClient\Message\ResponseMediator;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithTransactionDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithSigningUrlDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\Stringable;
use Spatie\ArrayToXml\ArrayToXml;
use Psr\Http\Message\ResponseInterface;

final class InitResponseDTO implements ResponseDTOInterface
{
    use WithTransactionDTO;
    use WithSigningUrlDTO;
    use WithSignatureDTO;
    use Stringable;
    
    private array $response;
    
    public function __construct(ResponseInterface $response)
    {
        $this->response = ResponseMediator::getSoapBody($response, 'InitOneSignResponse');
                
        $this->setTransactionId($this->response['transactionId']);
        $this->setSigningUrl($this->response['signingUrl']);
        $this->setSignature((string)\base64_decode($this->response['signature'], true));
    }
    
    public function isFilesExists(): bool
    {
        return false;
    }
    
    public function toArray(): array
    {
        return \array_filter([
            'transactionId' => $this->getTransactionId(),
            'signingUrl' => $this->getSigningUrl(),
        ]);
    }
}
