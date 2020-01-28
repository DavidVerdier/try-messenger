<?php

namespace App\Controller;

use App\Messenger\Messages\Message;
use App\Service\PdfCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessengerController extends AbstractController
{
    /**
     * @Route(name="messenger")
     */
    public function index()
    {
        $now = new \DateTime();

        //$this->dispatchMessage(new Message($now->format('H:i:s')));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'MessengerController',
        ]);
    }

    /**
     * @Route("/pdf", name="pdf")
     *
     * @param PdfCreator $pdfCreator
     * @return Response
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function pdf(PdfCreator $pdfCreator): Response
    {
        return $pdfCreator->create();
    }
}
