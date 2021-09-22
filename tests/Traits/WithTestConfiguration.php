<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\Entity\SigningType;

trait WithTestConfiguration
{
    public static function setUpTestConfiguration(): Configuration
    {
        return (new Configuration())
            ->setResponseUrl('http://aaaa')
            //->setAcceptableInfrastructure('Mobile')
            ->setSigningType(SigningType::SIGNATURE)
            ;
    }
    
    public static function setUpTestConfigurationWithLocale(string $locale): Configuration
    {
        return (new Configuration())
            ->setLocale($locale)
            ;
    }
    
    public static function setUpTestEmptyConfiguration(): Configuration
    {
        return new Configuration();
    }
}
