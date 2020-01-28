<?php

namespace App\Controller;

use App\Entity\Client;
use App\Messenger\Messages\Scenario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route("message/{id}", name="client", methods={"GET", "POST"})
     */
    public function client(Client $client)
    {
        $this->dispatchMessage(new Scenario($client));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'MessengerController',
        ]);
    }
}
