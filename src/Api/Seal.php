<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Api;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\SealResponseDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\Message\Response;

class Seal extends AbstractApi
{
    public function __invoke(RequestAdapter $requestAdapter): ResponseDTOInterface
    {
        $httpResponse = $this->makeHttpRequest($this->endpoint, $requestAdapter->toRequestDTO());
        
        $responseDTO = new SealResponseDTO($httpResponse);
        
        return (new Response($this->getClient()))
            ->get($responseDTO)
            ->validate()
            ->validateFiles()
            ->toDTO()
            ;
    }
}
