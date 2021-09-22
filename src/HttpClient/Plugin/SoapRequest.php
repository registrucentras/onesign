<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

final class SoapRequest implements Plugin
{
    private string $soapAction;
    
    public function __construct(string $soapAction)
    {
        $this->soapAction = $soapAction;
    }
    
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $request
            ->withHeader('Content-Type', 'text/xml; charset=UTF-8')
            ->withHeader('SOAPAction', \sprintf('http://www.registrucentras.lt/onesignservice/%s', $this->soapAction))
            ;

        return $next($request);
    }
}
