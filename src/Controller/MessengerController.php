<?php

namespace App\Controller;

use App\Messenger\Messages\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route(name="messenger")
     */
    public function index()
    {
        $now = new \DateTime();

        $this->dispatchMessage(new Message($now->format('H:i:s')));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'MessengerController',
        ]);
    }
}
