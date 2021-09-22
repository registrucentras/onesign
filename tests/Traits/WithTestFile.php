<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Entity\File;

trait WithTestFile
{
    public static function setUpTestFile(): File
    {
        return (new File())
            ->setName('aaaa')
            ->setContent(\file_get_contents(__DIR__ . '/../Files/sample.pdf'))
            ;
    }
}
