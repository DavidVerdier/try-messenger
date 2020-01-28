<?php

namespace App\Service;

use App\Messenger\Messages\Pdf;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PdfCreator
{
    private $html2pdf;

    private $twig;

    private $fileSystem;

    private $pdfDirectories;

    public function __construct(Environment $twig, array $pdfDirectories)
    {
        $this->html2pdf = new Html2Pdf();
        $this->twig = $twig;
        $this->fileSystem = new Filesystem();
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
        $content = $this->twig->render('pdf/pdf.html.twig');

        $this->html2pdf->writeHTML($content);

        $filename = $this->pdfDirectories['tmp'] . $pdf->getClientId() .'_'. uniqid() . '.pdf';

        $this->html2pdf->output($filename, 'F');
/*
        $output = file_get_contents($filename);

        $response = new Response($output, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="my_file.pdf"',
        ]);

        return $response;
*/
    }
}
