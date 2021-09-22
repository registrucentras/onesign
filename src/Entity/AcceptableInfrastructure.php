<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

final class AcceptableInfrastructure extends AbstractEntity implements EntityInterface
{
    /**
     * @var string
  */
    public const MOBILE = 'Mobile';
    
    /**
     * @var string
  */
    public const STATIONARY = 'Stationary';
}
