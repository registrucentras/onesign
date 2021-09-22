<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request;

use RegistruCentras\OneSign\HttpClient\Message\RequestMediator;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithClientDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithTransactionDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;

final class ResultRequestDTO implements RequestDTOInterface
{
    use WithClientDTO;
    use WithTransactionDTO;
    use WithSignatureDTO;
    
    public function __toString(): string
    {
        return \sprintf(
            '<clientId>%s</clientId><transactionId>%s</transactionId>',
            (string)$this->getClientId(),
            (string)$this->getTransactionId()
        );
    }
    
    public function toArray(): array
    {
        return [
            RequestMediator::elementWithNamespace('SigningResultRequest') => \array_filter([
                'clientId' => $this->getClientId(),
                'transactionId' => $this->getTransactionId(),
                'signature' => $this->getSignature(),
            ]),
        ];
    }
}
