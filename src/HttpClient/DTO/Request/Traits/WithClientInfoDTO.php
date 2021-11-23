<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithClientInfoDTO
{
    private string $clientId;

    private ?string $signerPersonalCode = null;

    private ?string $locale = null;

    private string $responseUrl;

    private ?string $acceptableInfrastructure = null;

    public function setClientId(string $clientId): RequestDTOInterface
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setSignerPersonalCode(?string $signerPersonalCode): RequestDTOInterface
    {
        $this->signerPersonalCode = $signerPersonalCode;
        return $this;
    }

    public function getSignerPersonalCode(): ?string
    {
        return $this->signerPersonalCode;
    }

    public function setLocale(?string $locale): RequestDTOInterface
    {
        $this->locale = $locale;
        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setResponseUrl(string $responseUrl): RequestDTOInterface
    {
        $this->responseUrl = $responseUrl;
        return $this;
    }

    public function getResponseUrl(): ?string
    {
        return $this->responseUrl;
    }

    public function setAcceptableInfrastructure(?string $acceptableInfrastructure): RequestDTOInterface
    {
        $this->acceptableInfrastructure = $acceptableInfrastructure;
        return $this;
    }

    public function getAcceptableInfrastructure(): ?string
    {
        return $this->acceptableInfrastructure;
    }
}
