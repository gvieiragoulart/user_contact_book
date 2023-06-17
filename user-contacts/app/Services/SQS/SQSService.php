<?php

namespace App\Services\SQS;

use Aws\Sqs\SqsClient;

class SQSService
{
    private $client;

    public function __construct()
    {
        $this->client = new SqsClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
        ]);
    }

    public function sendMessage($message): void
    {
        $this->client->sendMessage([
            'QueueUrl' => env('SQS_PREFIX') . '/' . env('SQS_QUEUE'),
            'MessageBody' => $message,
        ]);
    }

    
}