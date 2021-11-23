<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Message\Response\Status;

final class SigningResponseStatus
{
    /**
     * @var string
  */
    public const SIGNED = 'Signed';

    /**
     * @var string
  */
    public const CANCELED = 'Canceled';

    /**
     * @var string
  */
    public const IN_PROGRESS = 'InProgress';
}
