<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration;

interface DisplayProperties
{
    public function getPosition(): string;

    public function getDisplayValidity(): bool;

    public function getSignatureImageUrl(): ?string;

    public function getBackgroundImageUrl(): ?string;
}
