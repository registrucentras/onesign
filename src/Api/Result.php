<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Api;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\ResultResponseDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\Message\Response;

class Result extends AbstractApi
{

    public function __invoke(RequestAdapter $requestAdapter): ResponseDTOInterface
    {
        $httpResponse = $this->makeHttpRequest($this->endpoint, $requestAdapter->toRequestDTO());
        
        $responseDTO = new ResultResponseDTO($httpResponse);
        
        return (new Response($this->getClient()))
            ->get($responseDTO)
            ->validate()
            ->validateFiles()
            ->toDTO()
            ;
    }
}
