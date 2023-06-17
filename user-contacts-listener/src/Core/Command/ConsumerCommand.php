<?php

namespace Core\Command;

use Core\Services\LogService;
use Core\Services\MailService;
use Core\Services\SQSService;
use Exception;

require_once 'vendor/autoload.php';

class ConsumerCommand {    
    public function handle(SQSService $service) {
        try {
            $message = $service->receiveMessage();

            if (!empty($message)) {
                $receiptHandle = $message['ReceiptHandle'];
                $body = json_decode($message['Body'], true);

                $mailService = new MailService();

                $htmlContent = $this->getHtmlWelcomeContent($body);

                if(!$mailService->sendMail($body, $htmlContent)) {
                    LogService::logMessage('Erro ao enviar e-mail');
                }

                $service->deleteMessage($receiptHandle);
            }
        } catch (Exception $e) {
            LogService::logMessage($e->getMessage());
        }
    }

    private function getHtmlWelcomeContent(array $body): string
    {
        $html = file_get_contents('welcome.html');
        $html = str_replace('{{$nome}}', $body['name'], $html);
        $html = str_replace('{{$email}}', $body['email'], $html);

        return $html;
    }
}