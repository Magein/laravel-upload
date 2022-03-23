<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;
use mysql_xdevapi\Exception;


class UploadFactory
{
    /**
     * 上传的场景
     * @var string
     */
    protected string $scene = '';

    /**
     * 对应的字段信息
     * @var string
     */
    protected string $field = '';

    /**
     * @var UploadedFile|null
     */
    protected ?UploadedFile $file = null;

    /**
     * 获取config的setting类
     * @var string
     */
    protected $setting = '';

    /**
     * @var UploadConfig|null
     */
    protected ?UploadConfig $uploadConfig = null;

    /**
     * 设置的event
     * @var string
     */
    protected $event = '';

    /**
     * @var UploadEvent|null
     */
    protected ?UploadEvent $uploadEvent = null;

    public function __construct($arguments = [])
    {
        if ($arguments) {
            $this->setting = $arguments[0] ?? null;
            $this->event = $arguments[1] ?? null;
        }
    }

    public function postFile($file = 'file')
    {
        if (is_string($file)) {
            $this->file = request()->file($file);
        } elseif ($file instanceof UploadedFile) {
            $this->file = $file;
        }

        $this->scene = request()->input('name', '');
        $this->field = request()->input('field', '');

        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function error($message, $code = 1)
    {
        throw new HttpResponseException(response([
            'code' => 1,
            'msg' => $message
        ], 200));
    }

    public function store(...$params)
    {
        if (empty($this->file)) {
            $this->postFile();
        }

        $scene = config('upload.default.scene');
        if (empty($scene)) {
            $class = config('upload.default.driver') ?: 'local';
        } else {
            /**
             * @var UploadScene $scene
             */
            try {
                $scene = new $scene();
                $class = $scene->driver($this->scene, $this->field);
            } catch (\Exception $exception) {
                $class = null;
            }
        }

        if (empty($class)) {
            $class = 'local';
        }


        return $this->$class(...$params);
    }

    public function __call($name, $arguments)
    {
        $class = config('upload.' . $name . '.use');
        try {
            /**
             * @var UploadDriver $driver
             */
            $driver = new $class($arguments);
            return $driver->upload();
        } catch (Exception $exception) {

        }

        return null;
    }

    protected function upload()
    {
        $file = $this->file;
        if (empty($file)) {
            $this->postFile();
        }

        if (empty($this->file) || !$this->file instanceof UploadedFile) {
            $this->error('请上传文件');
        }

        $setting = $this->setting;
        if (empty($setting)) {
            $setting = config('upload.default.local.setting') ?: config('upload.default.setting');
        }

        try {
            $setting = new $setting($this->file, $this->name, $this->field);
            // 这里得到的就是config的实例，不需要在new了
            $config = $setting->config();
        } catch (\Exception $exception) {
            $config = null;
        }

        if (empty($config)) {
            $config = config('upload.' . $this->name() . '.config') ?: config('upload.default.config');
            try {
                $config = new $config();
            } catch (\Exception $exception) {
                $config = null;
            }
        }

        if (empty($config) || !$config instanceof UploadConfig) {
            $this->error('实例化配置文件失败');
        }
        $this->uploadConfig = $config;

        $event = $this->event;

        if (empty($event)) {
            $event = config('upload.' . $this->name() . '.event') ?: config('upload.default.event');
        }

        try {
            $event = new $event($this->file, $this->name, $this->field);
        } catch (\Exception $exception) {
            $event = null;
        }
        if (empty($event) || !$event instanceof UploadEvent) {
            $event = new UploadEvent($this->file, $this->name, $this->field);
        }

        $this->uploadEvent = $event;
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

        // 设置文件的保存路径
        $filepath = $this->uploadConfig->getSavePath();
        if (empty($filepath)) {
            $this->uploadConfig->getMimeType($this->file->getMimeType());
        }

        if (!$event->before()) {
            $this->error('event before error');
        }
    }
}
