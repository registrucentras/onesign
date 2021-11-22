<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

trait WithNoVisibleSignature
{
    public function getDisplayValidity(): bool
    {
        return false;
    }

    public function getSignatureImageUrl(): ?string
    {
        return null;
    }

    public function getBackgroundImageUrl(): ?string
    {
        return null;
    }
}
