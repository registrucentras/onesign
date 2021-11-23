<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Entity\Transaction;

trait WithTestTransaction
{
    public static function setUpTestTransaction(string $transactionId): Transaction
    {
        return (new Transaction())
            ->setTransactionId($transactionId)
            ;
    }

    public static function setUpTestRandomTransaction(): Transaction
    {
        return self::setUpTestTransaction((string)\random_int(111111, 999999))
            ;
    }

    public static function getSignedTransaction(): Transaction
    {
        return self::setUpTestTransaction('455371')
            ;
    }
}
