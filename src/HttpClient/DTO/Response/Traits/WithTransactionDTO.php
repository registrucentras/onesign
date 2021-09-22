<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;

trait WithTransactionDTO
{
    private string $transactionId;
    
    public function setTransactionId(string $transactionId): ResponseDTOInterface
    {
        $this->transactionId = $transactionId;
        return $this;
    }
    
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }
}
