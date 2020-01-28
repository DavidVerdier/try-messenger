<?php


namespace App\Messenger\Messages;


use App\Entity\Client;

class Message
{
    private $client;
    private $content;

    public function __construct(Client $client, string $content)
    {
        $this->client = $client;
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
