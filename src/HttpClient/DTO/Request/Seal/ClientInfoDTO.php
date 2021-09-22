<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Seal;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithClientDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\Stringable;

final class ClientInfoDTO implements RequestDTOInterface
{
    use WithClientDTO;
    use WithSignatureDTO;
    use Stringable;
    
    public function toArray(): array
    {
        return \array_filter([
            'clientId' => $this->getClientId(),
        ]);
    }
}
