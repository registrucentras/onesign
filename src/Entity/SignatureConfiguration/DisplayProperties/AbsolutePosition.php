<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithVisibleSignature;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithSignatureSize;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits\WithSignatureInPage;

final class AbsolutePosition implements DisplayProperties
{
    use WithVisibleSignature;
    use WithSignatureSize;
    use WithSignatureInPage;

    private string $x;

    private string $y;

    private string $width;

    private string $height;

    public function getPosition(): string
    {
        $page = $this->getPage();
        $positionX = $this->getX();
        $positionY = $this->getY();
        $width = $this->getWidth();
        $height = $this->getHeight();

        return \sprintf('absolute, %s, %s, %s, %s, %s', $page, $positionX, $positionY, $width, $height);
    }

    public function setX(string $x): DisplayProperties
    {
        $this->x = $x;
        return $this;
    }

    public function getX(): string
    {
        return $this->x;
    }

    public function setY(string $y): DisplayProperties
    {
        $this->y = $y;
        return $this;
    }

    public function getY(): string
    {
        return $this->y;
    }
}
