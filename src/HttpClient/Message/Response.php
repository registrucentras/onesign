<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Message;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\Util\Signatory;
use RegistruCentras\OneSign\HttpClient\Util\Files;

final class Response
{
    private Client $client;
    
    private ResponseDTOInterface $responseDTO;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function get(ResponseDTOInterface $responseDTO): self
    {
        $this->responseDTO = $responseDTO;
        return $this;
    }
    
    public function toDTO(): ResponseDTOInterface
    {
        return $this->responseDTO;
    }
    
    public function validate(): self
    {
        $publicKey = $this->client->getPublicKey();
        $content = (string)$this->responseDTO;
        $signature = $this->responseDTO->getSignature();
        
        Signatory::validate($this->client->getPublicKey(), $content, $signature);
        return $this;
    }
    
    public function validateFiles(): self
    {
        if ($this->responseDTO->isFilesExists()) {
            $fileDigest = $this->responseDTO->getFile()->getFileDigest();
            $fileContent = $this->responseDTO->getFile()->getContent();
        
            Files::validateDigest($fileContent, $fileDigest);
        }
        
        return $this;
    }
}
