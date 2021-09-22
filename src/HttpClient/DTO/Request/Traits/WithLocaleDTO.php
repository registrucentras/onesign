<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithLocaleDTO
{
    private ?string $locale = null;
    
    public function setLocale(?string $locale): RequestDTOInterface
    {
        $this->locale = $locale;
        return $this;
    }
    
    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
