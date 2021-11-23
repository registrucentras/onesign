<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithTransactionDTO
{
    private string $transactionId;

    public function setTransactionId(string $transactionId): RequestDTOInterface
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }
}
