<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithFileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\StringableWithFile;

final class FileDTO implements RequestDTOInterface
{
    use WithFileDTO;
    use WithSignatureDTO;
    use StringableWithFile;
    
    public function toArray(): array
    {
        return \array_filter([
            'fileDigest' => !\is_null($this->getFileDigest()) ? \base64_encode($this->getFileDigest()) : null,
            'fileName' => $this->getFileName(),
            'content' => !\is_null($this->getContent()) ? \base64_encode($this->getContent()) : null,
        ]);
    }
}
