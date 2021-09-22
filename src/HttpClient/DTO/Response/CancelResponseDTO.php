<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response;

use RegistruCentras\OneSign\HttpClient\Message\ResponseMediator;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\CancelSigningResponseStatus;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithFileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithStatusDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Result\FileDTO;
use Spatie\ArrayToXml\ArrayToXml;
use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface;

final class CancelResponseDTO implements ResponseDTOInterface
{
    use WithStatusDTO;
    
    public function __construct(ResponseInterface $response)
    {
        
        $httpStatus = ResponseMediator::getStatus($response);
        
        switch ($httpStatus) {
            case StatusCodeInterface::STATUS_ACCEPTED:
                $this->setStatus(CancelSigningResponseStatus::CANCELED);
                break;
            default:
                $this->setStatus(CancelSigningResponseStatus::ERROR);
                break;
        }
    }
    
    public function isFilesExists(): bool
    {
        return false;
    }
    
    public function __toString(): string
    {
        $array = $this->toArray();
        
        $arrayToXml = new ArrayToXml($array);
        
        return \preg_replace("/<\\/?root(\\s+.*?>|>)/", "", $arrayToXml->dropXmlDeclaration()->toXml());
    }
    
    public function toArray(): array
    {
        return [];
    }
}
