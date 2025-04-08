<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3Library
{
    private S3Client $s3Client;
    private string|bool|null $bucket;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_S3_ACCESS_KEY_ID'),
                'secret' => env('AWS_S3_SECRET_ACCESS_KEY'),
            ],
        ]);
        $this->bucket = env('AWS_S3_BUCKET');
    }

    public function uploadFile($filePath, $key): string
    {
        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => 'eggandbooks/' . $key,
                'SourceFile' => $filePath,
            ]);
            return (explode('eggandbooks/', $result->get('ObjectURL'))[1]);
        } catch (AwsException $e) {
            log_message('info', 'S3Library AwsException ::: ' . json_encode($e->getMessage()));
            log_message('info', 'S3Library AwsException ::: ' . json_encode($e->toArray()));
            return $e->getMessage();
        }
    }

    public function deleteFile($key): string
    {
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => 'eggandbooks/' . $key,
            ]);
            return 'success';
        } catch (AwsException $e) {
            log_message('info', 'deleteFile error ::: ' . json_encode($e->getMessage()));
            log_message('info', 'deleteFile error ::: ' . json_encode($e->toArray()));
            return $e->getMessage();
        }
    }
}
