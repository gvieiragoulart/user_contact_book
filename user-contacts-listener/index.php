<?php

use Core\Command\ConsumerCommand;
use Core\Services\SQSService;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

while(true) {
    $consumerCommand = new ConsumerCommand();
    $consumerCommand->handle(new SQSService());
    sleep(10);
}