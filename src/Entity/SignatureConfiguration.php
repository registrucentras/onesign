<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\Metadata;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

final class SignatureConfiguration extends AbstractEntity
{
    protected ?Metadata $metadata = null;

    protected ?DisplayProperties $displayProperties = null;

    public function setMetadata(Metadata $metadata): SignatureConfiguration
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function getMetadata(): ?Metadata
    {
        return $this->metadata;
    }

    public function setDisplayProperties(DisplayProperties $displayProperties): SignatureConfiguration
    {
        $this->displayProperties = $displayProperties;
        return $this;
    }

    public function getDisplayProperties(): ?displayProperties
    {
        return $this->displayProperties;
    }
}
