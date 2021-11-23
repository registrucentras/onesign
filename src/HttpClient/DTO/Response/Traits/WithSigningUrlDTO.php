<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;

trait WithSigningUrlDTO
{
    private string $signingUrl;

    public function setSigningUrl(string $signingUrl): ResponseDTOInterface
    {
        $this->signingUrl = $signingUrl;
        return $this;
    }

    public function getSigningUrl(): ?string
    {
        return $this->signingUrl;
    }
}
