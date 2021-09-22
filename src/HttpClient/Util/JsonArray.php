<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Util;

use RegistruCentras\OneSign\Exception\RuntimeException;

final class JsonArray
{
    public static function decode(string $json): array
    {
        /** @var scalar|array|null */
        $data = \json_decode($json, true);

        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new RuntimeException(\sprintf('json_decode error: %s', \json_last_error_msg()));
        }

        if (null === $data || !\is_array($data)) {
            throw new RuntimeException(\sprintf('json_decode error: Expected JSON of type array, %s given.', \get_debug_type($data)));
        }

        return $data;
    }

    public static function encode(array $value): string
    {
        $json = \json_encode($value);

        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new RuntimeException(\sprintf('json_encode error: %s', \json_last_error_msg()));
        }
        return (string)$json;
    }
}