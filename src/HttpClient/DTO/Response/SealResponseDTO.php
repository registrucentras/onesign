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
use RegistruCentras\OneSign\HttpClient\DTO\Response\Seal\FileDTO;
use Spatie\ArrayToXml\ArrayToXml;
use Psr\Http\Message\ResponseInterface;

final class SealResponseDTO implements ResponseDTOInterface
{
    use WithFileDTO;
    use WithStatusDTO;
    use WithSignatureDTO;
    use Stringable;
    
    private array $response;
    
    private FileDTO $file;
    
    private string $signerCertificate;
    
    private bool $signerCertificateTrusted;
    
    public function __construct(ResponseInterface $response)
    {
        
        $this->response = ResponseMediator::getSoapBody($response, 'SealResponse');

        switch ($this->response['status']) {
            case SigningResponseStatus::SIGNED:
                $file = $this->response['file'];
            
                $fileDTO = (new FileDTO())
                    ->setFileDigest((string)\base64_decode($file['fileDigest'], true))
                    ->setFileName($file['fileName'])
                    ->setContent((string)\base64_decode($file['content'], true))
                    ;
            
                $this->setFile($fileDTO);
                $this->setSignerCertificate((string)\base64_decode($this->response['signerCertificate'], true));
                $this->setSignerCertificateTrusted($this->response['signerCertificateTrusted']==='true');
                
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
    
    public function getSignerCertificate(): string
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
        return \array_filter([
            'status' => $this->getStatus(),
            'signerCertificate' => $this->getSignerCertificate(),
            'signerCertificateTrusted' => $this->getSignerCertificateTrusted() ? 'true' : 'false',
            'fileDigest' => $this->getFileDigest(),
            'fileName' => $this->getFileName(),
        ]);
    }
}
