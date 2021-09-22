<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Entity\Signer;

trait WithTestSigner
{
    public static function setUpTestSigner(string $personalCode = '3880000000'): Signer
    {
        return (new Signer())
            ->setPersonalCode($personalCode)
            ;
    }
    
    public static function setUpTestWithoutSigner(): Signer
    {
        return (new Signer())
            ;
    }
}
