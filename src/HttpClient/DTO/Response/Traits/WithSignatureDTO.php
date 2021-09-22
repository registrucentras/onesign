<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;

trait WithSignatureDTO
{
    private ?string $signature = null;
    
    public function setSignature(?string $signature): ResponseDTOInterface
    {
        $this->signature = $signature;
        return $this;
    }
    
    public function getSignature(): ?string
    {
        return $this->signature;
    }
}
