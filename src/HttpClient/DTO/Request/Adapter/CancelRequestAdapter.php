<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\DTO\Request\Adapter;

use RegistruCentras\OneSign\Client;
use RegistruCentras\OneSign\Entity\Transaction;
use RegistruCentras\OneSign\HttpClient\DTO\RequestDTOInterface;
use RegistruCentras\OneSign\HttpClient\DTO\Request\RequestAdapter;
use RegistruCentras\OneSign\HttpClient\DTO\Request\CancelRequestDTO;

final class CancelRequestAdapter implements RequestAdapter
{
    private Client $client;
    
    private Transaction $transaction;
    
    public function __construct(Client $client, Transaction $transaction)
    {
        $this->client = $client;
        $this->transaction = $transaction;
    }
    
    public function toRequestDTO(): RequestDTOInterface
    {
        
        return (new CancelRequestDTO())
            ->setClientId($this->client->getClientId())
            ->setTransactionId($this->transaction->getTransactionId());
    }
}
