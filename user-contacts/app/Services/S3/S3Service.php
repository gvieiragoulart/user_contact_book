<?php

namespace App\Services\S3;

use Aws\S3\S3Client;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class S3Service
{
    private S3Client $client;

    public function __construct()
    {
        $this->client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
        ]);
    }

    public function putObjectOnBucket(UploadedFile $file, $bucket = '/contacts-images-bucket'): string
    {
        try {
            $object = $this->client->putObject([
                'Bucket' => $bucket,
                'Key' => $file->getClientOriginalName(),
                'SourceFile' => $file,
            ]);

            return $object['ObjectURL'];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }
}