<?php


namespace App\MessageHandler;

use App\Message\TryMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class TryMessageHandler implements MessageHandlerInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * TryMessageHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param TryMessage $message
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function __invoke(TryMessage $message)
    {

        $now1 = new \DateTime();


        sleep(60);

        $now = new \DateTime();
        $html = sprintf('<p>Message created at %s</p><p>Handler called at : %s</p><p>Message sent at : %s</p>',
            $message->getContent(),
            $now1->format('H:i:s'),
            $now->format('H:i:s')
        );


        $email = (new Email())
            ->from('hello@mobiledev-pro.fr')
            ->to('david.verdier@mobiledev-pro.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->html($html);

        $this->mailer->send($email);

    }
}
