<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class Mailing
{
//    private $replyTo;
    public function __construct(private readonly MailerInterface $mailer) {
    
    }
    public function sendEmail($to,  $subject,$content): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('yesser.khaloui@etudiant-fst.utm.tn', 'E-Flex Bank'))
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