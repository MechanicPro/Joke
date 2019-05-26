<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_SmtpTransport;

class Mail
{
    const HOST = 'smtp.gmail.com';
    const PORT = 465;
    const ENCRIPTION = 'ssl';
    const USERNAME = 'ar.urbanmaf@gmail.com';
    const PASSWORD = '123qazxsw456';

    private $transport;
    private $mailer;

    public function __construct()
    {
        $this->transport = new Swift_SmtpTransport(self::HOST, self::PORT, self::ENCRIPTION);
        $this->transport->setUsername(self::USERNAME);
        $this->transport->setPassword(self::PASSWORD);

        $this->mailer = new Swift_Mailer($this->transport);
    }

    public function SendMessage($message)
    {
        $this->mailer->send($message);
    }
}