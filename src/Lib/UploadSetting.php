<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;

class UploadSetting
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

    public function __construct(UploadedFile $file, $name = '', $field = '')
    {
        $this->file = $file;
        $this->name = $name;
        $this->field = $field;
    }

    /**
     * @return UploadConfig
     */
    public function config(): UploadConfig
    {
        $config = new UploadConfig();
        $config->getMimeType($this->file->getMimeType());
        return $config;
    }
}
