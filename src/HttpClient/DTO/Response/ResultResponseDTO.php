<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Response;

use RegistruCentras\OneSign\HttpClient\Message\ResponseMediator;
use RegistruCentras\OneSign\HttpClient\Message\Response\Status\SigningResponseStatus;
use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithFileDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithStatusDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\WithSignatureDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Traits\Stringable;
use RegistruCentras\OneSign\HttpClient\DTO\Response\Result\FileDTO;
use Spatie\ArrayToXml\ArrayToXml;
use Psr\Http\Message\ResponseInterface;

final class ResultResponseDTO implements ResponseDTOInterface
{
    use WithStatusDTO;
    use WithSignatureDTO;
    use Stringable;

    private array $response;

    private FileDTO $file;

    private ?string $signerCertificate = null;

    private bool $signerCertificateTrusted = false;

    public function __construct(ResponseInterface $response)
    {
        $this->response = ResponseMediator::getSoapBody($response, 'SigningResultResponse');

        switch ($this->response['status']) {
            case SigningResponseStatus::SIGNED:
                $file = $this->response['file'];

                $fileDTO = (new FileDTO())
                    ->setFileDigest((string)\base64_decode($file['fileDigest'], true))
                    ->setFileName($file['fileName'])
                    ->setContent((string)\base64_decode($file['content'], true))
                    ;

                $this->setFile($fileDTO);
                $this->setSignerCertificate($this->response['signerCertificate']);
                $this->setSignerCertificateTrusted($this->response['signerCertificateTrusted'] === 'true');
                break;
            default:
                $this->setSignerCertificateTrusted(false);
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

    public function setSignerCertificate(string $signerCertificate): ResponseDTOInterface
    {
        $this->signerCertificate = $signerCertificate;
        return $this;
    }

    public function getSignerCertificate(): ?string
    {
        return $this->signerCertificate;
    }

    public function setSignerCertificateTrusted(bool $signerCertificateTrusted): ResponseDTOInterface
    {
        $this->signerCertificateTrusted = $signerCertificateTrusted;
        return $this;
    }

    public function getSignerCertificateTrusted(): bool
    {
        return $this->signerCertificateTrusted;
    }

    public function toArray(): array
    {
        $defaultArray = \array_filter([
            'status' => $this->getStatus(),
        ]);

        $signedArray = [];

        if ($this->getStatus() === SigningResponseStatus::SIGNED) {
            $signedArray = [
                'signerCertificate' => $this->getSignerCertificate(),
                'signerCertificateTrusted' => $this->getSignerCertificateTrusted() ? 'true' : 'false',
                'fileDigest' => \base64_encode((string)$this->getFile()->getFileDigest()),
                'fileName' => $this->getFile()->getFileName(),
            ];
        }

        return \array_filter(\array_merge($defaultArray, $signedArray));
    }
}
