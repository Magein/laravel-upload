<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;


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
     * @var UploadedFile
     */
    protected UploadedFile $file;

    /**
     * @var UploadConfig
     */
    protected UploadConfig $config;

    /**
     * @param UploadedFile|null $file
     * @param UploadConfig|null $config
     */
    public function __construct(UploadedFile $file = null, UploadConfig $config = null)
    {
        $this->name = (string)request('name', '');
        $this->field = (string)request('field', '');
        if (empty($file)) {
            $this->file = request()->file('file');
        } else {
            $this->file = $file;
        }
        $config && $this->config = $config;
    }

    public function setPostField($key)
    {
        $this->setFile(request()->file($key));
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
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
        
    }
}
