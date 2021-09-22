<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;

trait WithFileDTO
{
    private ?string $fileName = null;
    
    private ?string $content = null;
    
    private ?string $fileDigest = null;
    
    public function setFileName(?string $fileName): RequestDTOInterface
    {
        $this->fileName = $fileName;
        return $this;
    }
    
    public function getFileName(): ?string
    {
        return $this->fileName;
    }
    
    public function setContent(?string $content): RequestDTOInterface
    {
        $this->content = $content;
        return $this;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    public function setFileDigest(?string $fileDigest): RequestDTOInterface
    {
        $this->fileDigest = $fileDigest;
        return $this;
    }
    
    public function getFileDigest(): ?string
    {
        return $this->fileDigest;
    }
    
    public function withFileDigest(string $fileDigest): RequestDTOInterface
    {
        
        $fileDTO = clone $this;

        $fileDTO->setFileDigest($fileDigest);

        return $fileDTO;
    }
}
