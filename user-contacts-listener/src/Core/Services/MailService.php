<?php

namespace Core\Services;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once 'vendor/autoload.php';


class MailService {
    private $mail;
    
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = getenv('MAIL_HOST');
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('MAIL_USERNAME');
        $this->mail->Password = getenv('MAIL_PASSWORD');
        $this->mail->Port = getenv('MAIL_PORT');
    }

    public function sendMail(array $message, $htmlContent): bool
    {
        try {
            $this->mail->setFrom(getenv('MAIL_FROM'), getenv('MAIL_FROM_NAME'));
            $this->mail->addAddress($message['email'],$message['name']);
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Subject = 'Bem-vindo ao nosso sistema';
            $this->mail->Body = $htmlContent;
            $this->mail->AltBody = 'Habilite o suporte a HTML para visualizar este email corretamente.';
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            LogService::logMessage($e->getMessage());
            return false;
        }
    }
}