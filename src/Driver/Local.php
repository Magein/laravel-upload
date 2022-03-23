<?php

namespace Magein\Upload\Driver;

use Magein\Upload\AssetPath;
use Magein\Upload\Lib\UploadDriver;
use Magein\Upload\Lib\UploadEvent;
use Magein\Upload\Lib\UploadFactory;
use Magein\Upload\Lib\UploadConfig;

class Local extends UploadFactory implements UploadDriver
{

    /**
     * @throws \Exception
     */
    public function upload()
    {
        $setting = config('upload.default.setting');
        try {
            $config = (new $setting())->uploadConfig();
        } catch (\Exception $exception) {
            $config = $this->config;
        }

        if (empty($config)) {
            $config = config('upload.local.config');
            try {
                $config = new $config();
            } catch (\Exception $exception) {
                $config = null;
            }
        }

        if (empty($config) || !$config instanceof UploadConfig) {
            $this->error('实例化配置文件失败');
        }

        $event = config('upload.local.event');
        if ($event) {
            try {
                $event = new $event();
            } catch (\Exception $exception) {
                $event = null;
            }
        }

        if (empty($event) || !$event instanceof UploadEvent) {
            $event = new UploadEvent($this->file, $this->name, $this->field);
        }

        $event->before();

        $size = $config->getSize();
        $ext = $config->getExtend();
        $allow_size = $size * 1024;
        if ($this->file->getSize() > $allow_size) {
            $this->error('文件超出限制大小:允许的最大值为' . $allow_size . 'K');
        }

        $origin_ext = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext && !in_array($origin_ext, $ext)) {
            $this->error('不允许的文件类型');
        }
        $filepath = $config->getSavePath();
        $save_path = $this->file->store($filepath);

        if (!$save_path) {
            $event->fail();
            $event->final();
            $this->error('上传出现错误');
        }

        $save_path = AssetPath::replaceStorageFilePath($save_path);

        $data = [
            'filepath' => $save_path,
            'url' => AssetPath::getVisitPath($save_path)
        ];

        $event->success($data);
        $event->final();
        return $data;
    }
}
