<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Message;

use RegistruCentras\OneSign\Exception\RuntimeException;
use RegistruCentras\OneSign\HttpClient\Util\XmlArray;
use RegistruCentras\OneSign\HttpClient\Util\JsonArray;
use Psr\Http\Message\ResponseInterface;

final class ResponseMediator
{
    /**
     * @var string
     */
    public const CONTENT_TYPE_HEADER = 'Content-Type';

    /**
     * @var string
     */
    public const TEXT_XML_CONTENT_TYPE = 'text/xml;charset=utf-8';
    
    /**
  * @var string
  */
    public const SOAP_NAMESPACE = 'ns3';

    public static function getContent(ResponseInterface $response): array
    {
        if (202 === $response->getStatusCode()) {
            return [];
        }

        $body = (string) $response->getBody();

        if ('' === $body) {
            return [];
        }
        
        $headerLine = $response->getHeaderLine(self::CONTENT_TYPE_HEADER);
        
        $errorMessage = 'The response content type was not %s, response content is %s.';

        if (0 !== \strpos($response->getHeaderLine(self::CONTENT_TYPE_HEADER), self::TEXT_XML_CONTENT_TYPE)) {
            throw new RuntimeException(\sprintf($errorMessage, self::TEXT_XML_CONTENT_TYPE, $headerLine));
        }

        return XmlArray::decode($body);
    }
    
    public static function getErrorMessage(ResponseInterface $response): ?string
    {
        try {
            /** @var scalar|array */
            $error = self::getContent($response)['error'] ?? null;
        } catch (RuntimeException $e) {
            return null;
        }

        return \is_array($error) ? self::getMessageFromError($error) : null;
    }
    
    private static function getMessageFromError(array $error): ?string
    {
        /** @var scalar|array */
        $message = $error['message'] ?? '';

        if (!\is_string($message)) {
            return null;
        }

        $detail = self::getDetailAsString($error);

        if ('' !== $message) {
            return '' !== $detail ? \sprintf('%s: %s', $message, $detail) : $message;
        }

        if ('' !== $detail) {
            return $detail;
        }

        return null;
    }

    private static function getDetailAsString(array $error): string
    {
        /** @var string|array $detail */
        $detail = $error['detail'] ?? '';

        if ('' === $detail || [] === $detail) {
            return '';
        }

        return (string) \strtok(\is_string($detail) ? $detail : JsonArray::encode($detail), "\n");
    }
    
    public static function getStatus(ResponseInterface $response): int
    {
        
        return $response->getStatusCode();
    }
    
    public static function getSoapBody(ResponseInterface $response, string $element): array
    {
        return self::getContent($response)['SOAP-ENV:Body'][self::elementWithNamespace($element)];
    }
    
    public static function getSoapErrorMessage(ResponseInterface $response): ?string
    {
        return self::getContent($response)['SOAP-ENV:Body']['SOAP-ENV:Fault']['faultstring']['@content'];
    }
    
    public static function elementWithNamespace(string $element): string
    {
        return \sprintf('%s:%s', self::SOAP_NAMESPACE, $element);
    }
}
