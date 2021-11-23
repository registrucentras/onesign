<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

final class SigningType extends AbstractEntity implements EntityInterface
{
    /**
     * @var string
  */
    public const SIGNATURE = 'Signature';

    /**
     * @var string
     */
    public const SIGNATURE_WITH_TIMESTAMP = 'SignatureWithTimestamp';

    /**
     * @var string
     */
    public const SIGNATURE_WITH_TIMESTAMP_OCSP = 'SignatureWithTimestampOCSP';
}
