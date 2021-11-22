<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO;

interface RequestDTOInterface
{
    public function toArray(): array;

    public function __toString(): string;

    public function withSignature(string $signature): RequestDTOInterface;

    public function withBased64Signature(string $signature): RequestDTOInterface;
}
