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
use RegistruCentras\OneSign\HttpClient\DTO\Request\InitRequestDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\ClientInfoDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\FileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\SignatureMetadataDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\Init\SignatureDisplayPropertiesDTO;

final class InitRequestAdapter implements RequestAdapter
{
    private Client $client;

    private Signer $signer;

    private File $file;

    private SignatureConfiguration $signatureConfiguration;

    private Configuration $configuration;

    public function __construct(
        Client $client,
        Signer $signer,
        File $file,
        SignatureConfiguration $signatureConfiguration,
        Configuration $configuration
    ) {
        $this->client = $client;
        $this->signer = $signer;
        $this->file = $file;
        $this->signatureConfiguration = $signatureConfiguration;
        $this->configuration = $configuration;
    }

    public function toRequestDTO(): RequestDTOInterface
    {

        $clientInfo = (new ClientInfoDTO())
            ->setClientId($this->client->getClientId())
            ->setSignerPersonalCode($this->signer->getPersonalCode())
            ->setLocale($this->configuration->getLocale())
            ->setResponseUrl($this->configuration->getResponseUrl())
            ->setAcceptableInfrastructure($this->configuration->getAcceptableInfrastructure())
            ;

        $file = (new FileDTO())
            ->setFileName($this->file->getName())
            ->setContent($this->file->getContent())
            ;


        $initRequestDTO = (new InitRequestDTO())
            ->setClientInfo($clientInfo)
            ->setFile($file->withFileDigest(Files::generateFileDigest($file->getContent())))
            ->setSigningType($this->configuration->getSigningType())
            ;

        if ($this->signatureConfiguration->getMetadata() !== null) {
            $metadata = (new SignatureMetadataDTO())
                ->setReason($this->signatureConfiguration->getMetadata()->getReason())
                ->setLocation($this->signatureConfiguration->getMetadata()->getLocation())
                ->setContact($this->signatureConfiguration->getMetadata()->getContact())
                ;

            $initRequestDTO = $initRequestDTO->withSignatureMetadata($metadata);
        }

        if ($this->signatureConfiguration->getDisplayProperties() !== null) {
            $signatureDisplayProperties = (new SignatureDisplayPropertiesDTO())
                ->setPosition($this->signatureConfiguration->getDisplayProperties()->getPosition())
                ->setDisplayValidity($this->signatureConfiguration->getDisplayProperties()->getDisplayValidity())
                ->setSignatureImageUrl($this->signatureConfiguration->getDisplayProperties()->getSignatureImageUrl())
                ->setBackgroundImageUrl($this->signatureConfiguration->getDisplayProperties()->getBackgroundImageUrl())
                ;

            $initRequestDTO = $initRequestDTO->withSignatureDisplayProperties($signatureDisplayProperties);
        }

        return $initRequestDTO;
    }
}
