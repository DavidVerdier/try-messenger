<?php


namespace App\Messenger\Messages;


class Pdf
{
    private $clientId;

    public function __construct(int $clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }
}
