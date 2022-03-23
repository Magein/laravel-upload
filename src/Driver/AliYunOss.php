<?php

namespace Magein\Upload\Driver;

use Magein\Upload\Lib\UploadDriver;
use Magein\Upload\Lib\UploadFactory;
use OSS\Core\OssException;
use OSS\OssClient;

class AliYunOss extends UploadFactory implements UploadDriver
{
    public function name()
    {
        return 'aliyun';
    }

    public function upload()
    {
        $config = config('upload.aliyun');

        $access_key_id = $config['access_key_id'] ?? '';
        $access_key_secret = $config['access_key_secret'] ?? '';
        $endpoint = $config['endpoint'] ?? '';
        $bucket = $config['bucket'] ?? '';

        try {
            $client = new OssClient(
                $access_key_id,
                $access_key_secret,
                $endpoint->getEndpoint()
            );
            // 使用https
            $client->setUseSSL(true);
        } catch (OssException $exception) {
            $client = null;
        }

        if ($client) {
            try {
                $result = $client->uploadFile($bucket, $this->uploadConfig->getSavePath(), $this->file->getRealPath());
            } catch (OssException $exception) {

            }
        }
    }
}
