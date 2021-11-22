<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity\SignatureConfiguration;

final class Metadata
{
    private ?string $reason = null;

    private ?string $location = null;

    private ?string $contact = null;

    public function setReason(?string $reason): Metadata
    {
        $this->reason = $reason;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setLocation(?string $location): Metadata
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setContact(?string $contact): Metadata
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }
}
