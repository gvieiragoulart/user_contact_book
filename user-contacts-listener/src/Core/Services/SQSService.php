<?php

namespace Core\Services;
require_once 'vendor/autoload.php';

use Aws\Sqs\SqsClient;

class SQSService {
    private $client;
    
    public function __construct()
    {
        $this->client = new SqsClient([
            'region' => getenv('AWS_DEFAULT_REGION', 'us-east-1'),
            'version' => 'latest',
            'use_path_style_endpoint' => getenv('AWS_USE_PATH_STYLE_ENDPOINT'),
        ]); 
    }

    public function receiveMessage(): array
    {
        $result = $this->client->receiveMessage([
            'QueueUrl' => getenv('SQS_PREFIX') . '/' . getenv('SQS_QUEUE')
        ]);

        if(!$result->get('Messages')) {
            return [];
        }

        return $result->get('Messages')[0];
    }

    public function deleteMessage(string $receiptHandle): void
    {
        $this->client->deleteMessage([
            'QueueUrl' => getenv('SQS_PREFIX') . '/' . getenv('SQS_QUEUE'),
            'ReceiptHandle' => $receiptHandle,
        ]);
    }

}