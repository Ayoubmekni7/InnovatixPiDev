<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class mailing
{
    public function __construct(private readonly MailerInterface $mailer)
    {

    }
    public function sendEmail($to,$subject ,$content): void
    {
        $email = (new Email())
            ->from('yesser.khaloui@etudiant-fst.utm.tn')
            ->to($to)
            ->subject($subject)
            ->html($content);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception ){

        }

    }

}