<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Plugin;

use RegistruCentras\OneSign\Exception\ApiLimitExceededException;
use RegistruCentras\OneSign\Exception\ExceptionInterface;
use RegistruCentras\OneSign\Exception\RuntimeException;
use RegistruCentras\OneSign\Exception\ValidationFailedException;
use RegistruCentras\OneSign\Exception\SoapErrorException;
use RegistruCentras\OneSign\HttpClient\Message\ResponseMediator;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ExceptionThrower implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response): ResponseInterface {
            $status = $response->getStatusCode();

            if ($status >= 400 && $status < 600) {
                throw self::createException($response);
            }

            return $response;
        });
    }

    private static function createException(ResponseInterface $response): ExceptionInterface
    {
        $status = $response->getStatusCode();

        if (400 === $status || 422 === $status) {
            $errorMessage = ResponseMediator::getErrorMessage($response) ?? $response->getReasonPhrase();

            return new ValidationFailedException($errorMessage, $status);
        }

        if (500 === $status) {
            $errorMessage = ResponseMediator::getSoapErrorMessage($response) ?? $response->getReasonPhrase();

            return new SoapErrorException($errorMessage, $status);
        }

        $errorMessage =  ResponseMediator::getErrorMessage($response) ?? $response->getReasonPhrase();

        return new RuntimeException($errorMessage, $status);
    }
}
