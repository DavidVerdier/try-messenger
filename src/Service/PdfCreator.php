<?php


namespace App\Service;


use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PdfCreator
{
    private $html2pdf;

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->html2pdf = new Html2Pdf();
        $this->twig = $twig;
    }

    /**
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create()
    {
        $content = $this->twig->render('pdf/pdf.html.twig');

        $this->html2pdf->writeHTML($content);
        $output = $this->html2pdf->output();

        $response = new Response($output, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="my_file.pdf"',
        ]);

        return $response;
    }
}
