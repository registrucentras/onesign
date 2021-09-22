<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

trait WithVisibleSignature
{
    private bool $displayValidity = false;
    
    private ?string $signatureImageUrl = null;
    
    private ?string $backgroundImageUrl = null;
    
    public function setDisplayValidity(bool $displayValidity): DisplayProperties
    {
        $this->displayValidity = $displayValidity;
        return $this;
    }
    
    public function getDisplayValidity(): bool
    {
        return $this->displayValidity;
    }
    
    public function setSignatureImageUrl(string $signatureImageUrl): DisplayProperties
    {
        $this->signatureImageUrl = $signatureImageUrl;
        return $this;
    }
     
    public function getSignatureImageUrl(): ?string
    {
        return $this->signatureImageUrl;
    }
     
    public function setBackgroundImageUrl(string $backgroundImageUrl): DisplayProperties
    {
        $this->backgroundImageUrl = $backgroundImageUrl;
        return $this;
    }
    
    public function getBackgroundImageUrl(): ?string
    {
        return $this->backgroundImageUrl;
    }
}
