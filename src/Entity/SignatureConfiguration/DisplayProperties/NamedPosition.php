<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithVisibleSignature;

final class NamedPosition implements DisplayProperties
{
    use WithVisibleSignature;

    private string $fieldName;

    public function getPosition(): string
    {
        return \sprintf('named, %s', $this->getFieldName());
    }

    public function setFieldName(string $fieldName): DisplayProperties
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
