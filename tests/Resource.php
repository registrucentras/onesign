<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests;

final class Resource
{
    public static function get(string $path)
    {
        $content = @\file_get_contents(\sprintf('%s/Resource/%s', __DIR__, $path));

        if (false === $content) {
            throw new \RuntimeException(\sprintf('Unable to read resource [%s].', $path));
        }

        return $content;
    }
}
