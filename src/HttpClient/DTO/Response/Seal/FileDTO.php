<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Seal;

use Spatie\ArrayToXml\ArrayToXml;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithFileDTO;

final class FileDTO implements ResponseDTOInterface
{
    use WithFileDTO;

    public function __toString(): string
    {

        $array = $this->toArray();

        unset($array['content']);

        $arrayToXml = new ArrayToXml($array);

        return \preg_replace("/<\\/?root(\\s+.*?>|>)/", "", $arrayToXml->dropXmlDeclaration()->toXml());
    }

    public function toArray(): array
    {
        return \array_filter([
            'fileDigest' => !\is_null($this->getFileDigest()) ? \base64_encode($this->getFileDigest()) : null,
            'fileName' => $this->getFileName(),
            'content' => !\is_null($this->getContent()) ? \base64_encode($this->getContent()) : null,
        ]);
    }
}
