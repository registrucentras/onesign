<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request;

use RegistruCentras\OneSign\HttpClient\Message\RequestMediator;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp\ClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp\FileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;

final class TimestampRequestDTO implements RequestDTOInterface
{
    use WithSignatureDTO;
    
    private ClientInfoDTO $clientInfo;
    
    private FileDTO $file;
    
    public function setClientInfo(ClientInfoDTO $clientInfo): RequestDTOInterface
    {
        $this->clientInfo = $clientInfo;
        return $this;
    }
    
    public function getClientInfo(): ClientInfoDTO
    {
        return $this->clientInfo;
    }
    
    public function setFile(FileDTO $file): RequestDTOInterface
    {
        $this->file = $file;
        return $this;
    }
    
    public function getFile(): FileDTO
    {
        return $this->file;
    }
    
    public function __toString(): string
    {
        return \sprintf(
            '%s%s',
            (string)$this->clientInfo,
            (string)$this->file
        );
    }
    
    public function toArray(): array
    {
        return [
            RequestMediator::elementWithNamespace('TimestampRequest') => \array_filter([
                RequestMediator::elementWithNamespace('clientInfo') => $this->clientInfo->toArray(),
                RequestMediator::elementWithNamespace('file') => $this->file->toArray(),
                RequestMediator::elementWithNamespace('signature') => $this->getSignature(),
            ]),
        ];
    }
}
