<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use Spatie\ArrayToXml\ArrayToXml;

trait StringableWithFile
{
    public function __toString(): string
    {
        
        $array = $this->toArray();
        
        unset($array['content']);
        
        $arrayToXml = new ArrayToXml($array);
        
        return \preg_replace("/<\\/?root(\\s+.*?>|>)/", "", $arrayToXml->dropXmlDeclaration()->toXml());
    }
}
