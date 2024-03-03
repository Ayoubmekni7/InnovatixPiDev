<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailing
{
//    private $replyTo;
    public function __construct(private readonly MailerInterface $mailer) {
    
    }
    public function sendEmail($to,  $subject,$content): void
    {
        $email = (new Email())
            ->from('yesser.khaloui@etudiant-fst.utm.tn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            // ->replyTo($this->replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
//            ->text('Sending emails is fun again!')
            ->html($content);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
        // ...
    }

}
//php bin/console messenger:consume async