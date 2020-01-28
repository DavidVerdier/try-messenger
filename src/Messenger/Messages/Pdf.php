<?php


namespace App\Messenger\Messages;


use App\Entity\Client;

class Pdf
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
