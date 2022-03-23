<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;

class UploadSetting
{
    /**
     * 获取上传的配置信息
     * @param UploadedFile $file
     * @param $name
     * @param $filed
     * @return UploadConfig
     */
    public function uploadConfig(UploadedFile $file, $name = '', $filed = ''): UploadConfig
    {
        $config = new UploadConfig();
        $config->getMimeType($file->getMimeType());
        return $config;
    }
}