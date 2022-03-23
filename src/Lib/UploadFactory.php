<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;
use mysql_xdevapi\Exception;


class UploadFactory
{
    /**
     * 上传的标记
     * @var string
     */
    protected string $name = '';

    /**
     * 对应的字段信息
     * @var string
     */
    protected string $field = '';

    /**
     * @var UploadedFile|null
     */
    protected ?UploadedFile $file = null;

    public function postFile($file = 'file')
    {
        if (is_string($file)) {
            $this->file = request()->file($file);
        } elseif ($file instanceof UploadedFile) {
            $this->file = $file;
        }

        $this->name = request()->input('name', '');
        $this->field = request()->input('field', '');

        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function error($message, $code = 1)
    {
        throw new \Exception($message, $code = 1);
    }

    public function store()
    {
        if (empty($this->file)) {
            $this->postFile();
        }

        $class = config('upload.default.driver') ?: 'local';

        return $this->$class();
    }

    public function __call($name, $arguments)
    {
        $class = config('upload.' . $name . '.use');
        try {
            /**
             * @var UploadDriver $driver
             */
            $driver = new $class();
            $res = $driver->upload();
        } catch (Exception $exception) {
            $res = null;
        }

        return $res;
    }
}
