<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request;

use RegistruCentras\OneSign\HttpClient\Message\RequestMediator;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\ClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\SignatureMetadataDTO as MetadataDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\SignatureDisplayPropertiesDTO as DisplayPropertiesDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\FileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Traits\WithSigningTypeDTO;

final class InitRequestDTO implements RequestDTOInterface
{
    use WithSignatureDTO;
    use WithSigningTypeDTO;
    
    private ClientInfoDTO $clientInfo;
    
    private ?MetadataDTO $metadata = null;
    
    private ?DisplayPropertiesDTO $displayProperties = null;
    
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
    
    public function setSignatureMetadata(MetadataDTO $metadata): RequestDTOInterface
    {
        $this->metadata = $metadata;
        return $this;
    }
    
    public function getSignatureMetadata(): ?MetadataDTO
    {
        return $this->metadata;
    }
    
    public function withSignatureMetadata(MetadataDTO $metadata): RequestDTOInterface
    {
        $dto = clone $this;
        
        $dto->metadata = $metadata;
        return $dto;
    }
    
    public function setSignatureDisplayProperties(DisplayPropertiesDTO $displayProperties): RequestDTOInterface
    {
        $this->displayProperties = $displayProperties;
        return $this;
    }
    
    public function getSignatureDisplayProperties(): ?DisplayPropertiesDTO
    {
        return $this->displayProperties;
    }
    
    public function withSignatureDisplayProperties(DisplayPropertiesDTO $displayProperties): RequestDTOInterface
    {
        $dto = clone $this;
        
        $dto->displayProperties = $displayProperties;
        return $dto;
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
            '%s%s%s%s%s',
            (string)$this->clientInfo,
            (string)$this->metadata,
            (string)$this->displayProperties,
            \sprintf('<signingType>%s</signingType>', $this->getSigningType()),
            (string)$this->file
        );
    }
    
    public function toArray(): array
    {
        $metadata = !\is_null($this->metadata) ? $this->metadata->toArray() : null;
        $displayProperties = !\is_null($this->displayProperties) ? $this->displayProperties->toArray() : null;
        
        return [
            RequestMediator::elementWithNamespace('InitOneSignRequest') => \array_filter([
                RequestMediator::elementWithNamespace('clientInfo') => $this->clientInfo->toArray(),
                RequestMediator::elementWithNamespace('signatureMetadata') => $metadata,
                RequestMediator::elementWithNamespace('signatureDisplayProperties') => $displayProperties,
                RequestMediator::elementWithNamespace('signingType') => $this->getSigningType(),
                RequestMediator::elementWithNamespace('file') => $this->file->toArray(),
                RequestMediator::elementWithNamespace('signature') => $this->getSignature(),
            ]),
        ];
    }
}
