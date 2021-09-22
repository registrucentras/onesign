<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithNoVisibleSignature;

final class HiddenPosition implements DisplayProperties
{
    use WithNoVisibleSignature;
    
    public function getPosition(): string
    {
        return 'hidden';
    }
}
