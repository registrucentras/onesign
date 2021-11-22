<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;

trait WithStatusDTO
{
    private string $status;

    public function setStatus(string $status): ResponseDTOInterface
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
