<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// ###    Messenger    ###
use App\Message\TryMessage;
use Symfony\Component\Messenger\MessageBusInterface;
// ###  End Messenger  ###


class MessengerController extends AbstractController
{

    /**
     * @Route(name="messenger")
     */
    public function index(MessageBusInterface $bus)
    {

    $now =  new \DateTime();
//die('OK');
    $try = $bus->dispatch(new TryMessage($now->format('H:i:s')));

dump($try);die;
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MessengerController.php',
        ]);
    }

    /**
     * @Route("/test", name="messenger_test")
     */
    public function test()
    {
        $this->dispatchMessage(new TryMessage('Look! I created a message method 2!'));


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MessengerController.php',
        ]);
    }
}
