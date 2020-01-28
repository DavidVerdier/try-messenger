<?php

namespace App\Controller;

use App\Messenger\Messages\Scenario;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route("client/{id}", name="client", methods={"GET", "POST"})
     */
    public function client(int $id, ClientRepository $clientRepository)
    {
        $client = $clientRepository->find($id);

        if (null === $client) {
            throw $this->createNotFoundException('Not found');
        }

        $this->dispatchMessage(new Scenario($client));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'MessengerController',
        ]);
    }
}
