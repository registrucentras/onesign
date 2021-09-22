<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Util;

use RegistruCentras\OneSign\Exception\RuntimeException;
use Gaarf\XmlToPhp\Convertor;

final class XmlArray
{
    public static function decode(string $xml): array
    {
        return Convertor::covertToArray($xml);
    }

    public static function encode(array $value): string
    {
        $json = \json_encode($value);

        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new RuntimeException(\sprintf('json_encode error: %s', \json_last_error_msg()));
        }

        /** @var string */
        return $json;
    }
}
