<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithVisibleSignature;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithSignatureSize;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithSignatureInPage;

final class RelativePosition implements DisplayProperties
{
    use WithVisibleSignature;
    use WithSignatureSize;
    use WithSignatureInPage;
    
    private float $x;
    
    private float $y;
    
    public function getPosition(): string
    {
        $page = $this->getPage();
        $positionX = $this->getX();
        $positionY = $this->getY();
        $width = $this->getWidth();
        $height = $this->getHeight();
        
        return \sprintf('relative, %s, %.3f, %.3f, %s, %s', $page, $positionX, $positionY, $width, $height);
    }
    
    public function setX(float $x): DisplayProperties
    {
        $this->x = $x;
        return $this;
    }
    
    public function getX(): float
    {
        return $this->x;
    }
    
    public function setY(float $y): DisplayProperties
    {
        $this->y = $y;
        return $this;
    }
    
    public function getY(): float
    {
        return $this->y;
    }
}
