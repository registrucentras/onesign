<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use Spatie\ArrayToXml\ArrayToXml;

trait Stringable
{
    public function __toString(): string
    {
        
        $array = $this->toArray();
        
        $arrayToXml = new ArrayToXml($array);
        
        return \preg_replace("/<\\/?root(\\s+.*?>|>)/", "", $arrayToXml->dropXmlDeclaration()->toXml());
    }
}
