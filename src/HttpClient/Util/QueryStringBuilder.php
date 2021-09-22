<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Util;

final class QueryStringBuilder
{
    public static function build(array $query): string
    {
        if (0 === \count($query)) {
            return '';
        }

        return \sprintf('?%s', \http_build_query($query, '', '&', \PHP_QUERY_RFC3986));
    }
}
