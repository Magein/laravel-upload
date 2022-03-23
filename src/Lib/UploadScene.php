<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;

class UploadScene
{
    /**
     * 上传的场景标记
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

    public function __construct(UploadedFile $file, $scene = '', $field = '')
    {
        $this->file = $file;
        $this->scene = $scene;
        $this->field = $field;
    }

    public function driver(): string
    {
        return 'local';
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