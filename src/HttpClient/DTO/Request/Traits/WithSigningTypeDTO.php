<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithSigningTypeDTO
{
    private string $signingType;
    
    public function setSigningType(string $signingType): RequestDTOInterface
    {
        $this->signingType = $signingType;
        return $this;
    }
    
    public function getSigningType(): string
    {
        return $this->signingType;
    }
}
