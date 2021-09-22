<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Message\Response\Status;

final class CancelSigningResponseStatus
{
    /**
     * @var string
  */
    public const CANCELED = 'Canceled';
    
    /**
     * @var string
  */
    public const ERROR = 'Error';
}
