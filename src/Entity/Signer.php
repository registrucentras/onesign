<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

use RegistruCentras\OneSign\Entity\EntityInterface;

final class Signer extends AbstractEntity implements EntityInterface
{
    protected ?string $personalCode = null;

    public function setPersonalCode(string $personalCode): EntityInterface
    {
        $this->personalCode = $personalCode;
        return $this;
    }

    public function getPersonalCode(): ?string
    {
        return $this->personalCode;
    }
}
