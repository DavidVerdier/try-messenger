<?php


namespace App\Messenger\Handlers;

use App\Messenger\Messages\Aws;
use App\Messenger\Messages\Message;
use App\Messenger\Messages\Pdf;
use App\Messenger\Messages\Scenario;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ScenarioHandler implements MessageHandlerInterface
{
    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * ScenarioHandler constructor.
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Pdf $pdf
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Scenario $scenario)
    {

        $client = $scenario->getClient();

        $this->bus->dispatch(new Pdf($client));
        $this->bus->dispatch(new Aws($client));
        $this->bus->dispatch(new Message($client, "Voici ton message"));
    }
}
