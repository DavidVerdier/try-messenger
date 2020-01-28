<?php


namespace App\Messenger\Handlers;

use App\Messenger\Messages\Message;
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

    /**
     * TryMessageHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
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
        $now1 = new \DateTime();
        sleep(10);
        $now = new \DateTime();

        $html = $this->twig->render('email/message.html.twig', array(
            'message' => $message,
            'calledAt' => $now1->format('H:i:s'),
            'sentAt' => $now->format('H:i:s')
        ));

        $email = (new Email())
            ->from('hello@mobiledev-pro.fr')
            ->to('david.verdier@mobiledev-pro.fr')
            ->subject('Time for Symfony Mailer!')
            ->html($html);

        $this->mailer->send($email);
    }
}
