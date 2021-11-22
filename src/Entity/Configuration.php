<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

use RegistruCentras\OneSign\Entity\EntityInterface;

final class Configuration extends AbstractEntity implements EntityInterface
{
    protected ?string $locale = null;

    protected string $responseUrl;

    protected ?string $acceptableInfrastructure  = null;

    protected string $signingType;

    public function setLocale(string $locale): EntityInterface
    {
        $this->locale = $locale;
        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setResponseUrl(string $responseUrl): EntityInterface
    {
        $this->responseUrl = $responseUrl;
        return $this;
    }

    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    public function setAcceptableInfrastructure(?string $acceptableInfrastructure): EntityInterface
    {
        $this->acceptableInfrastructure = $acceptableInfrastructure;
        return $this;
    }

    public function getAcceptableInfrastructure(): ?string
    {
        return $this->acceptableInfrastructure;
    }

    public function setSigningType(string $signingType): EntityInterface
    {
        $this->signingType = $signingType;
        return $this;
    }

    public function getSigningType(): string
    {
        return $this->signingType;
    }
}
