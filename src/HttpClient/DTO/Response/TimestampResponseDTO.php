<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response;

use RegistruCentras\OneSign\HttpClient\Message\ResponseMediator;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\SigningResponseStatus;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithStatusDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\Stringable;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Result\FileDTO;
use Psr\Http\Message\ResponseInterface;

final class TimestampResponseDTO implements ResponseDTOInterface
{
    use WithStatusDTO;
    use WithSignatureDTO;
    use Stringable;

    private array $response;

    private FileDTO $file;

    public function __construct(ResponseInterface $response)
    {
        $this->response = ResponseMediator::getSoapBody($response, 'TimestampResponse');

        switch ($this->response['status']) {
            case SigningResponseStatus::SIGNED:
                $file = $this->response['file'];

                $fileDTO = (new FileDTO())
                    ->setFileDigest((string)\base64_decode($file['fileDigest'], true))
                    ->setFileName($file['fileName'])
                    ->setContent((string)\base64_decode($file['content'], true))
                    ;

                $this->setFile($fileDTO);

                break;
        }

        $this->setStatus($this->response['status']);
        $this->setSignature((string)\base64_decode($this->response['signature'], true));
    }

    public function setFile(FileDTO $file): ResponseDTOInterface
    {
        $this->file = $file;
        return $this;
    }

    public function getFile(): FileDTO
    {
        return $this->file;
    }

    public function isFilesExists(): bool
    {
        return isset($this->file);
    }

    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->getStatus(),
            'fileDigest' => \base64_encode((string)$this->getFile()->getFileDigest()),
            'fileName' => $this->getFile()->getFileName(),
        ]);
    }
}
