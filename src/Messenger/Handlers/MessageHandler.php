<?php


namespace App\Messenger\Handlers;

use App\Messenger\Messages\Message;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MessageHandler implements MessageHandlerInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    private $twig;

    private $repository;

    private $em;

    /**
     * @var array
     */
    private $pdfDirectories;

    /**
     * TryMessageHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer, Environment $twig, ClientRepository $clientRepository, EntityManagerInterface $entityManager, array $pdfDirectories)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
        $this->pdfDirectories = $pdfDirectories;
        $this->repository = $clientRepository;
        $this->twig = $twig;
    }

    /**
     * @param Message $message
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Message $message)
    {
        $client = $this->repository->find($message->getClient()->getId());

        if (true === $client->getSent()) {
            return;
        }

        $now1 = new \DateTime();
        sleep(10);
        $now = new \DateTime();

        $html = $this->twig->render('email/message.html.twig', array(
            'message' => $message,
            'calledAt' => $now1->format('H:i:s'),
            'sentAt' => $now->format('H:i:s')
        ));

        $originalFile = $this->pdfDirectories['tmp'] . $client->getPdf();

        $email = (new Email())
            ->from('hello@mobiledev-pro.fr')
            ->to($client->getEmail())
            ->subject('Salut ' . $client->getName())
            ->html($html)
            ->attachFromPath($originalFile);

        $this->mailer->send($email);

        $client->setSent(true);
        $this->em->persist($client);
        $this->em->flush();
    }
}
