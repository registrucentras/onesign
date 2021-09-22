<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

trait WithSignatureSize
{
    private string $width;
    
    private string $height;
    
    public function setWidth(string $width): DisplayProperties
    {
        $this->width = $width;
        return $this;
    }
    
    public function getWidth(): string
    {
        return $this->width;
    }
    
    public function setHeight(string $height): DisplayProperties
    {
        $this->height = $height;
        return $this;
    }
    
    public function getHeight(): string
    {
        return $this->height;
    }
}
