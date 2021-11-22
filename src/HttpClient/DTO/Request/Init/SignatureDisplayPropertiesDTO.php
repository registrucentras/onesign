<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Init;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDisplayPropertiesDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\Stringable;

final class SignatureDisplayPropertiesDTO implements RequestDTOInterface
{
    use WithSignatureDisplayPropertiesDTO;
    use WithSignatureDTO;
    use Stringable;

    public function toArray(): array
    {
        return \array_filter([
            'position' => $this->getPosition(),
            'displayValidity' => $this->getDisplayValidity() ? 'true' : null,
            'signatureImageUrl' => $this->getSignatureImageUrl(),
            'backgroundImageUrl' => $this->getBackgroundImageUrl(),
        ]);
    }
}
