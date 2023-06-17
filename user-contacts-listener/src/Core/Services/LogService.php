<?php

namespace Core\Services;

require_once 'vendor/autoload.php';


class LogService {
    public static function logMessage(string $message): void
    {
        file_put_contents('app.log', date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL, FILE_APPEND);
    }
}