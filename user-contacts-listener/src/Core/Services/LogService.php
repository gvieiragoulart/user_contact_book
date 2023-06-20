<?php

namespace Core\Services;

use Exception;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Logger;

require_once 'vendor/autoload.php';

class LogService {
    public function logMessageInAppLog(string $message): void
    {
        file_put_contents('app.log', date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL, FILE_APPEND);
    }

    public static function logMessage(string $message)
    {
        try {
            $host = getenv('LOG_HOST');
            $port = getenv('LOG_PORT');

            $handler = new SocketHandler("udp://{$host}:{$port}");
            $handler->setFormatter(new LogstashFormatter('UserContactsListener', getenv('APP_NAME', 'UserContactsListener')));

            $logger = new Logger('logstash.main', [$handler]);
            $logger->info($message);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            self::logMessageInAppLog($message);
        }
    }

}