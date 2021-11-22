<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Message;

use Spatie\ArrayToXml\ArrayToXml;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

final class RequestMediator
{
    /**
     * @var string
  */
    public const SOAP_NAMESPACE = 'ones';

    private static function generateRoot(): array
    {
        return [
            'rootElementName' => 'soapenv:Envelope',
            '_attributes' => [
                'xmlns:soapenv' => 'http://schemas.xmlsoap.org/soap/envelope/',
                'xmlns:ones' => 'http://www.registrucentras.lt/onesignservice',
            ],
        ];
    }

    public static function generateRequestRawBody(RequestDTOInterface $requestDTO): string
    {

        $array = [
            'soapenv:Header' => [],
            'soapenv:Body' => $requestDTO->toArray(),
        ];

        $arrayToXml = new ArrayToXml($array, self::generateRoot());

        return $arrayToXml->dropXmlDeclaration()->toXml();
    }

    public static function elementWithNamespace(string $element): string
    {
        return \sprintf('%s:%s', self::SOAP_NAMESPACE, $element);
    }
}
