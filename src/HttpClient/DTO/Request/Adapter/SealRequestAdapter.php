<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\Entity\Signer;
use RegistruCentras\OneSign\Entity\File;
use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\HttpClient\Util\Files;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\SealRequestDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Seal\ClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Seal\FileDTO;

final class SealRequestAdapter implements RequestAdapter
{
    private Client $client;
    
    private File $file;
    
    public function __construct(Client $client, File $file)
    {
        $this->client = $client;
        $this->file = $file;
    }
    
    public function toRequestDTO(): RequestDTOInterface
    {
        
        $clientInfo = (new ClientInfoDTO())
            ->setClientId($this->client->getClientId())
            ;
            
        $file = (new FileDTO())
            ->setFileName($this->file->getName())
            ->setContent($this->file->getContent())
            ;
        
        return (new SealRequestDTO())
            ->setClientInfo($clientInfo)
            ->setFile($file->withFileDigest(Files::generateFileDigest($file->getContent())));
    }
}
