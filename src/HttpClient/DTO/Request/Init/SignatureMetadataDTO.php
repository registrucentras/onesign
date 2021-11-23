<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Init;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureMetadataDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\Stringable;

final class SignatureMetadataDTO implements RequestDTOInterface
{
    use WithSignatureMetadataDTO;
    use WithSignatureDTO;
    use Stringable;

    public function toArray(): array
    {
        return \array_filter([
            'reason' => $this->getReason(),
            'location' => $this->getLocation(),
            'contact' => $this->getContact(),
        ]);
    }
}
