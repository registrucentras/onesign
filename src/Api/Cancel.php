<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Api;

use RegistruCentras\OneSign\HttpClient\DTO\ResponseDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Response\CancelResponseDTO;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\Message\Response;

class Cancel extends AbstractApi
{
    public function __invoke(RequestAdapter $requestAdapter): ResponseDTOInterface
    {
        $httpResponse = $this->makeHttpRequest($this->endpoint, $requestAdapter->toRequestDTO());
        
        $responseDTO = new CancelResponseDTO($httpResponse);
        
        return (new Response($this->getClient()))
            ->get($responseDTO)
            ->toDTO()
            ;
    }
}
