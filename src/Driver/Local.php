<?php

namespace Magein\Upload\Driver;

use Magein\Upload\AssetPath;
use Magein\Upload\Lib\UploadDriver;
use Magein\Upload\Lib\UploadFactory;

class Local extends UploadFactory implements UploadDriver
{

    public function name()
    {
        return 'local';
    }

    /**
     * @throws \Exception
     */
    public function upload()
    {
        parent::upload();

        $filepath = $this->uploadConfig->getSavePath();
        $save_path = $this->file->store($filepath);

        if (!$save_path) {
            $this->uploadEvent->fail();
            $this->uploadEvent->final();
            $this->error('上传出现错误');
        }

        $save_path = AssetPath::replaceStorageFilePath($save_path);

        $data = [
            'filepath' => $save_path,
            'url' => AssetPath::getVisitPath($save_path)
        ];

        $this->uploadEvent->success($data);
        $this->uploadEvent->final();
        return $data;
    }
}
