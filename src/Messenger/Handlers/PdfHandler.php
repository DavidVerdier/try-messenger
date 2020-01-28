<?php


namespace App\Messenger\Handlers;

use App\Messenger\Messages\Pdf;
use App\Service\PdfCreator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PdfHandler implements MessageHandlerInterface
{
    /**
     * @var PdfCreator
     */
    private $pdfCreator;

    /**
     * PdfHandler constructor.
     * @param PdfCreator $pdfCreator
     */
    public function __construct(PdfCreator $pdfCreator)
    {
        $this->pdfCreator = $pdfCreator;
    }

    /**
     * @param Pdf $pdf
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Pdf $pdf)
    {
        sleep(5);
        $this->pdfCreator->create($pdf);
    }
}
