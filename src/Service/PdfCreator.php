<?php

namespace App\Service;

use App\Messenger\Messages\Pdf;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spipu\Html2Pdf\Html2Pdf;
use Twig\Environment;

class PdfCreator
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $pdfDirectories;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * PdfCreator constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $em
     * @param ClientRepository $clientRepository
     * @param array $pdfDirectories
     */
    public function __construct(Environment $twig, EntityManagerInterface $em, ClientRepository $clientRepository, array $pdfDirectories)
    {
        $this->repository = $clientRepository;
        $this->twig = $twig;
        $this->em = $em;
        $this->pdfDirectories = $pdfDirectories;
    }

    /**
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create(Pdf $pdf)
    {
        sleep(15);

        $client = $this->repository->find($pdf->getClient()->getId());

        $html2pdf = new Html2Pdf();

        $content = $this->twig->render('pdf/pdf.html.twig', ['client' => $pdf->getClient()]);

        $html2pdf->writeHTML($content);

        $filename = $client->getId() .'_'. uniqid() . '.pdf';

        $client->setPdf($filename);

        $html2pdf->output($this->pdfDirectories['tmp'] .  $filename, 'F');

        $this->em->persist($client);
        $this->em->flush();
    }
}
