<?php

namespace Magein\Upload\Lib;

interface UploadDriver
{
    /**
     * 驱动的名称
     * @return string
     */
    public function name();

    /**
     * 上传文件
     * @return array
     */
    public function upload();

    /**
     * base64的字符串保存成图片信息
     * @return mixed
     */
    public function base64();
}
