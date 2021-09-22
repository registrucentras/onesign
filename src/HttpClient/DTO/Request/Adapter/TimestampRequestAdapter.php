<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\Entity\Signer;
use RegistruCentras\OneSign\Entity\File;
use RegistruCentras\OneSign\Entity\Configuration;
use RegistruCentras\OneSign\HttpClient\Util\Files;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\TimestampRequestDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp\ClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Timestamp\FileDTO;

final class TimestampRequestAdapter implements RequestAdapter
{
    private Client $client;
    
    private Signer $signer;
    
    private File $file;
    
    private Configuration $configuration;
    
    public function __construct(Client $client, Signer $signer, File $file, Configuration $configuration)
    {
        $this->client = $client;
        $this->signer = $signer;
        $this->file = $file;
        $this->configuration = $configuration;
    }
    
    public function toRequestDTO(): RequestDTOInterface
    {
        
        $clientInfo = (new ClientInfoDTO())
            ->setClientId($this->client->getClientId())
            ->setSignerPersonalCode($this->signer->getPersonalCode())
            ->setLocale($this->configuration->getLocale())
            ;
            
        $file = (new FileDTO())
            ->setFileName($this->file->getName())
            ->setContent($this->file->getContent())
            ;
        
        return (new TimestampRequestDTO())
            ->setClientInfo($clientInfo)
            ->setFile($file->withFileDigest(Files::generateFileDigest($file->getContent())));
    }
}
