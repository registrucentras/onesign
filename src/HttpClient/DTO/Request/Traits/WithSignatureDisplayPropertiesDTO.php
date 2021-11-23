<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithSignatureDisplayPropertiesDTO
{


    private ?string $position = null;

    private bool $displayValidity = false;

    private ?string $signatureImageUrl = null;

    private ?string $backgroundImageUrl = null;

    public function setPosition(string $position): RequestDTOInterface
    {
        $this->position = $position;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setDisplayValidity(bool $displayValidity): RequestDTOInterface
    {
        $this->displayValidity = $displayValidity;
        return $this;
    }

    public function getDisplayValidity(): bool
    {
        return $this->displayValidity;
    }

    public function setSignatureImageUrl(?string $signatureImageUrl): RequestDTOInterface
    {
        $this->signatureImageUrl = $signatureImageUrl;
        return $this;
    }

    public function getSignatureImageUrl(): ?string
    {
        return $this->signatureImageUrl;
    }

    public function setBackgroundImageUrl(?string $backgroundImageUrl): RequestDTOInterface
    {
        $this->backgroundImageUrl = $backgroundImageUrl;
        return $this;
    }

    public function getBackgroundImageUrl(): ?string
    {
        return $this->backgroundImageUrl;
    }
}
