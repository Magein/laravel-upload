<?php

namespace Magein\Upload\Lib;

use Illuminate\Http\UploadedFile;

class UploadEvent
{
    protected ?UploadedFile $file = null;

    protected string $name = '';

    protected string $field = '';

    public function __construct(UploadedFile $file, $name = '', $filed = '')
    {
        $this->file = $file;
        $this->name = $name;
        $this->field = $filed;
    }

    public function before()
    {

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