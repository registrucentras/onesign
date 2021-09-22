<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithSignatureDTO
{
    private string $signature;
    
    public function setSignature(string $signature): RequestDTOInterface
    {
        $this->signature = $signature;
        return $this;
    }
    
    public function getSignature(): ?string
    {
        return $this->signature;
    }
    
    public function withSignature(string $signature): RequestDTOInterface
    {
        $signatureDTO = clone $this;

        $signatureDTO->setSignature($signature);

        return $signatureDTO;
    }
    
    public function withBased64Signature(string $signature): RequestDTOInterface
    {
        $signatureDTO = clone $this;

        $signatureDTO->setSignature(\base64_encode($signature));

        return $signatureDTO;
    }
}
