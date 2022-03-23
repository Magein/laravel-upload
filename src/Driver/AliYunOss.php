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
        parent::upload();

        $config = config('upload.aliyun');

        $access_key_id = $config['access_key_id'] ?? '';
        $access_key_secret = $config['access_key_secret'] ?? '';
        $endpoint = $config['endpoint'] ?? '';
        $bucket = $config['bucket'] ?? '';

        try {
            $client = new OssClient(
                $access_key_id,
                $access_key_secret,
                $endpoint
            );
            // 使用https
            $client->setUseSSL(true);
        } catch (OssException $exception) {
            $this->error($exception->getMessage());
        }

        $save_path = $this->uploadConfig->getSavePath();
        // 保存地址是一个路径，不是指向一个文件
        $ext = pathinfo($save_path, PATHINFO_EXTENSION);
        if (empty($ext)) {
            $save_path .= '/' . md5(uniqid()) . '.' . $this->file->getClientOriginalExtension();
        }

        try {
            $result = $client->uploadFile($bucket, $save_path, $this->file->getRealPath());
        } catch (OssException $exception) {
            $this->error($exception->getMessage());
        }

        $filepath = $result['info']['url'];
        $data = [
            'filepath' => $filepath,
            'url' => $filepath
        ];

        $this->uploadEvent->success($data);
        $this->uploadEvent->final();
        return $data;
    }

    public function base64()
    {
        
    }
}
