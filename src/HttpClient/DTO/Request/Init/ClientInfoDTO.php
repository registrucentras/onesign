<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Init;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\Stringable;

final class ClientInfoDTO implements RequestDTOInterface
{
    use WithClientInfoDTO;
    use WithSignatureDTO;
    use Stringable;

    public function toArray(): array
    {
        return \array_filter([
            'clientId' => $this->getClientId(),
            'signerPersonalCode' => $this->getSignerPersonalCode(),
            'locale' => $this->getLocale(),
            'responseUrl' => $this->getResponseUrl(),
            'acceptableInfrastructure' => $this->getAcceptableInfrastructure(),
        ]);
    }
}
