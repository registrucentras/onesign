<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithSignatureMetadataDTO
{
    private ?string $reason = null;

    private ?string $location = null;

    private ?string $contact = null;

    public function setReason(?string $reason): RequestDTOInterface
    {
        $this->reason = $reason;
        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setLocation(?string $location): RequestDTOInterface
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setContact(?string $contact): RequestDTOInterface
    {
        $this->contact = $contact;
        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }
}
