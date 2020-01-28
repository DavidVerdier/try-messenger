<?php


namespace App\Messenger\Handlers;

use App\Messenger\Messages\Aws;
use App\Messenger\Messages\Pdf;
use App\Service\AwsManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AwsHandler implements MessageHandlerInterface
{
    /**
     * @var AwsManager
     */
    private $awsManager;

    /**
     * AwsHandler constructor.
     * @param AwsManager $awsManager
     */
    public function __construct(AwsManager $awsManager)
    {
        $this->awsManager = $awsManager;
    }

    /**
     * @param Pdf $pdf
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Aws $aws)
    {
        sleep(20);
        $this->awsManager->uploadToAws($aws);
    }
}
