<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

use RegistruCentras\OneSign\Entity\EntityInterface;

final class Transaction extends AbstractEntity implements EntityInterface
{
    protected string $transactionId;
    
    public function setTransactionId(string $transactionId): EntityInterface
    {
        $this->transactionId = $transactionId;
        return $this;
    }
    
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }
}
