<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\Traits;

use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties;

trait WithSignatureInPage
{
    private int $page;

    public function setPage(int $page): DisplayProperties
    {
        $this->page = $page;
        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
