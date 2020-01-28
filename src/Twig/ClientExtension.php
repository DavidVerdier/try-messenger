<?php

namespace App\Twig;

use App\Entity\Client;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ClientExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('get_status', [$this, 'getStatus']),
        ];
    }

    public function getStatus(Client $client)
    {
        if (null === $client->getPdf()) {
            return "PDF en création";
        }

        if (false === $client->getSent())  {
            return "Mail en cours d'envoie";
        }

        return "Upload aws en cours";
    }
}
