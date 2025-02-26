<?php

namespace Core\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{

    protected PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = config('email.host', 'smtp.example.com');
        $this->mailer->SMTPAuth = config('email.auth', true);
        $this->mailer->Username = config('email.username', '');
        $this->mailer->Password = config('email.password', '');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = config('email.port', 587);
    }

    public function send(string $to, string $subject, string $body, string $from = ''): bool
    {
        try {
            $this->mailer->setFrom($from ?: config('email.from', 'no-reply@example.com'));
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            return $this->mailer->send();
        } catch (Exception $e) {
            return false;
        }
    }

}