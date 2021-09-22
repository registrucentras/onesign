<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

interface RequestAdapter
{
    public function toRequestDTO(): RequestDTOInterface;
}
