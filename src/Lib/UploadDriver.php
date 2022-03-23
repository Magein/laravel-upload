<?php

namespace Magein\Upload\Lib;

interface UploadDriver
{
    public function upload();

    public function name();
}
