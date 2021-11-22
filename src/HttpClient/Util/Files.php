<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Util;

use RegistruCentras\OneSign\Exception\FileValidationFailedException;

final class Files
{
    public static function generateFileDigest(string $content): string
    {
        return \hash('sha1', $content, true);
    }

    public static function validateDigest(string $fileContent, string $fileDigest): void
    {
        $tempFileDigest = self::generateFileDigest($fileContent);

        if ($fileDigest !== $tempFileDigest) {
            throw new FileValidationFailedException('Can not validate file by file digest!');
        }
    }
}
