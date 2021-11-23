<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use Spatie\ArrayToXml\ArrayToXml;

trait Stringable
{
    public function __toString(): string
    {

        $arrayToXml = new ArrayToXml($this->toArray());

        return \preg_replace("/<\\/?root(\\s+.*?>|>)/", "", $arrayToXml->dropXmlDeclaration()->toXml());
    }
}
