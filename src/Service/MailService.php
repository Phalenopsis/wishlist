<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    public function send(Request $request, MailerInterface $mailer): void
    {
        $email = (new Email())
            ->from('nicos@nico.com')
            ->to('user@nico.com')
            ->subject('welcome')
            ->html('<div>Plop !!!</div>');
        $mailer->send($email);
    }
}
