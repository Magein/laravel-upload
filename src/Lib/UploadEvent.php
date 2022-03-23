<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;

class UploadEvent
{
    protected ?UploadedFile $file = null;

    /**
     * 使用的场景
     * @var string
     */
    protected string $scene = '';

    /**
     * 对应的字段信息
     * @var string|mixed
     */
    protected string $field = '';

    public function __construct($file = null, $scene = '', $filed = '')
    {
        $this->file = $file;
        $this->scene = $scene;
        $this->field = $filed;
    }

    public function before()
    {
        return true;
    }

    public function success($data)
    {

    }

    public function fail()
    {

    }

    public function final()
    {

    }
}
