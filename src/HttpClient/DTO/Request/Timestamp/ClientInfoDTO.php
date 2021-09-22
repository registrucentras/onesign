<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithClientDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithLocaleDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\Stringable;

final class ClientInfoDTO implements RequestDTOInterface
{
    use WithClientDTO;
    use WithLocaleDTO;
    use WithSignatureDTO;
    use Stringable;
    
    private ?string $signerPersonalCode = null;
    
    public function setSignerPersonalCode(?string $signerPersonalCode): RequestDTOInterface
    {
        $this->signerPersonalCode = $signerPersonalCode;
        return $this;
    }
    
    public function getSignerPersonalCode(): ?string
    {
        return $this->signerPersonalCode;
    }
    
    public function toArray(): array
    {
        return \array_filter([
            'clientId' => $this->getClientId(),
        ]);
    }
}
