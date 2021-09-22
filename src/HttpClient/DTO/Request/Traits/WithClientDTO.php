<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithClientDTO
{
    private string $clientId;
    
    public function setClientId(string $clientId): RequestDTOInterface
    {
        $this->clientId = $clientId;
        return $this;
    }
    
    public function getClientId(): ?string
    {
        return $this->clientId;
    }
}
