<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response\Traits;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;

trait WithFileDTO
{
    private ?string $fileName = null;

    private ?string $content = null;

    private ?string $fileDigest = null;

    public function setFileName(string $fileName): ResponseDTOInterface
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setContent(?string $content): ResponseDTOInterface
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setFileDigest(?string $fileDigest): ResponseDTOInterface
    {
        $this->fileDigest = $fileDigest;
        return $this;
    }

    public function getFileDigest(): ?string
    {
        return $this->fileDigest;
    }

    public function withFileDigest(string $fileDigest): ResponseDTOInterface
    {
        $fileDTO = clone $this;

        $fileDTO->setFileDigest($fileDigest);

        return $fileDTO;
    }
}
